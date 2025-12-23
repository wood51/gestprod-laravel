import re
import json
import csv
import subprocess
from pathlib import Path

import pdfplumber


# =========================
# Regex
# =========================
PA_RE = re.compile(r"\bPA[\s\-]*(\d{6,7})\b", re.I)
DATE_CMD_RE = re.compile(r"\bDATE\s*:\s*(\d{2}/\d{2}/\d{4})\b", re.I)
ACHETEUR_LINE_RE = re.compile(r"^\s*Acheteur\s*:\s*(.+)\s*$", re.I | re.M)
AVENANT_FLAG_RE = re.compile(r"\bAVENANT\b", re.I)

ROW_RE = re.compile(
    r"^\s*(\d{1,3})\s+"  # poste
    r"([A-Z0-9][A-Z0-9._-]{3,})\s+"  # code_article
    r"(\d{2}/\d{2}/\d{4})\s+"  # date_livraison
    r"(\d+(?:[.,]\d+)?)\s+"  # quantite
    r"([A-Z]{1,3})\b"  # unité (U, PC, etc.)
)


class ManualParseRequired(Exception):
    """PDF non parseable automatiquement (format hors standard)."""

    pass

# =========================
# Clipboard (Windows)
# =========================
def copy_to_clipboard(text: str) -> None:
    subprocess.run(
        [
            "powershell",
            "-NoProfile",
            "-Command",
            "Set-Clipboard -Value ([Console]::In.ReadToEnd())",
        ],
        input=text,
        text=True,
        check=True,
    )


# =========================
# Mapping + TSV aligned for Excel columns
# =========================
def excel_col_to_index(col: str) -> int:
    col = col.upper().strip()
    n = 0
    for c in col:
        n = n * 26 + (ord(c) - ord("A") + 1)
    return n


def load_mapping(path: Path) -> dict:
    if not path.exists():
        raise FileNotFoundError(f"Mapping introuvable: {path}")
    data = json.loads(path.read_text(encoding="utf-8"))

    if not isinstance(data, dict) or "excel_mapping" not in data:
        raise ValueError("mapping.json invalide: attendu une clé 'excel_mapping'.")

    mapping = data["excel_mapping"]
    if not isinstance(mapping, dict) or not mapping:
        raise ValueError(
            "mapping.json invalide: 'excel_mapping' doit être un dict non vide."
        )

    # sanity check
    for field, col in mapping.items():
        if not isinstance(field, str) or not isinstance(col, str):
            raise ValueError(
                "mapping.json invalide: champs/colonnes doivent être des strings."
            )
        excel_col_to_index(col)  # valide le format colonne

    return mapping


def to_tsv_excel_aligned(result: dict, mapping: dict) -> str:
    idx_map = {field: excel_col_to_index(col) for field, col in mapping.items()}
    max_col = max(idx_map.values())

    pa = result.get("pa") or ""
    out_lines = []

    for row in result.get("lignes", []):
        cells = [""] * max_col
        for field, col_idx in idx_map.items():
            value = pa if field == "pa" else row.get(field, "")

            # ✅ Excel: force poste en texte (sinon 1.10 devient 1.1)
            if field == "poste":
                value = str(value)

            cells[col_idx - 1] = str(value)

        out_lines.append("\t".join(cells))

    return "\n".join(out_lines)



# =========================
# Parsing
# =========================
def clean_acheteur(raw: str) -> str:
    return re.split(r"\s{2,}", raw.strip(), maxsplit=1)[0].strip()


def load_code_map(path: Path) -> dict:
    if not path.exists():
        return {}
    try:
        data = json.loads(path.read_text(encoding="utf-8"))
        return data.get("codes", {}) if isinstance(data, dict) else {}
    except Exception:
        return {}


def map_code_article(code: str, code_map: dict) -> str:
    return code_map.get(code, code)

def explode_quantites(lignes: list[dict]) -> list[dict]:
    out = []

    for row in lignes:
        q_raw = str(row.get("quantite", "1")).strip().replace(",", ".")
        try:
            qte = int(float(q_raw))
        except ValueError:
            qte = 1

        base_poste = str(row.get("poste", "")).strip()

        if qte <= 1 or not base_poste:
            row2 = row.copy()
            row2["poste"] = base_poste
            out.append(row2)
            continue

        width = len(str(qte))  # 10 -> 2, 250 -> 3, etc.

        for i in range(1, qte + 1):
            row2 = row.copy()
            row2["poste"] = f"{base_poste}-{str(i)}"
            row2["quantite"] = "1"
            out.append(row2)

    return out



def parse_pdf(pdf_path: Path, code_map: dict | None = None, debug: bool = False) -> dict:
    if code_map is None:
        code_map = {}

    pdf_path = Path(pdf_path)

    # ✅ result initialisé tout de suite
    result = {
        "pa": None,
        "date_commande": None,
        "acheteur": None,
        "source_file": pdf_path.name,
        "is_avenant": False,
        "lignes": [],
    }

    pages_text: list[str] = []
    with pdfplumber.open(pdf_path) as pdf:
        for page in pdf.pages:
            t = page.extract_text(layout=True) or page.extract_text() or ""
            pages_text.append(t)

    full_text = "\n".join(pages_text)

    # flags header
    result["is_avenant"] = bool(AVENANT_FLAG_RE.search(full_text))

    pa_m = PA_RE.search(full_text)
    date_m = DATE_CMD_RE.search(full_text)
    acheteur_m = ACHETEUR_LINE_RE.search(full_text)

    if pa_m:
        result["pa"] = "PA" + pa_m.group(1)
    if date_m:
        result["date_commande"] = date_m.group(1)
    if acheteur_m:
        result["acheteur"] = clean_acheteur(acheteur_m.group(1))

    # lines
    for pi, text in enumerate(pages_text, start=1):
        for ln in text.splitlines():
            m = ROW_RE.match(ln)
            if not m:
                continue

            poste, code, date_liv, qty, _unit = m.groups()

            mapped_code = code_map.get(code, code)  # fallback automatique

            row = {
                "poste": int(poste),  # (ou str si tu fais le .1/.2 après)
                "code_article": mapped_code,
                "date_livraison": date_liv,
                "quantite": qty.replace(",", "."),
            }
            result["lignes"].append(row)

            if debug:
                print(f"[p{pi}] {row} | raw: {ln}")

    result["lignes"] = explode_quantites(result["lignes"])

    return result

def validate_parse(result: dict) -> None:
    if not result["lignes"]:
        raise ManualParseRequired("aucune ligne détectée")

    for i, row in enumerate(result["lignes"], start=1):
        if not row.get("poste"):
            raise ManualParseRequired(f"poste manquant (ligne {i})")
        if not row.get("code_article"):
            raise ManualParseRequired(f"code_article manquant (ligne {i})")
        if not row.get("date_livraison"):
            raise ManualParseRequired(f"date_livraison manquante (ligne {i})")
        if not row.get("quantite"):
            raise ManualParseRequired(f"quantite manquante (ligne {i})")

# =========================
# Optional file outputs
# =========================
def write_json(out_path: Path, data: dict) -> None:
    out_path.write_text(
        json.dumps(data, ensure_ascii=False, indent=2), encoding="utf-8"
    )


def write_csv(out_path: Path, data: dict) -> None:
    with out_path.open("w", newline="", encoding="utf-8") as f:
        w = csv.writer(f, delimiter=";")
        w.writerow(
            [
                "pa",
                "date_commande",
                "acheteur",
                "source_file",
                "poste",
                "code_article",
                "date_livraison",
                "quantite",
            ]
        )
        for r in data["lignes"]:
            w.writerow(
                [
                    data["pa"],
                    data["date_commande"],
                    data["acheteur"],
                    data["source_file"],
                    r["poste"],
                    r["code_article"],
                    r["date_livraison"],
                    r["quantite"],
                ]
            )


# =========================
# CLI
# =========================
if __name__ == "__main__":
    import argparse

    ap = argparse.ArgumentParser()
    ap.add_argument("pdf", help="Chemin du PDF")
    ap.add_argument("--debug", action="store_true")
    ap.add_argument(
        "--mapping",
        default="mapping.json",
        help="Fichier mapping (défaut: mapping.json)",
    )
    ap.add_argument(
        "--out",
        help="Si fourni: écrit JSON/CSV dans ce dossier (sinon, aucun fichier).",
    )
    ap.add_argument(
        "--code-map",
        default="code_map.json",
        help="Mapping des codes articles (optionnel)",
    )
    ap.add_argument("--json-stdout", action="store_true", help="Sort le JSON sur stdout (pour Laravel)")

    args = ap.parse_args()

    pdf_path = Path(args.pdf)
    if not pdf_path.exists():
        raise SystemExit(f"PDF introuvable: {pdf_path}")

    mapping_path = Path(args.mapping)
    mapping = load_mapping(mapping_path)

    code_map = load_code_map(Path(args.code_map))

    try:
        data = parse_pdf(pdf_path, code_map=code_map, debug=args.debug)
        validate_parse(data)
    except ManualParseRequired as e:
        print(f"[MANUAL] {pdf_path.name} → {e}")
        raise SystemExit(2)

    # Mode Laravel : JSON direct
    if args.json_stdout:
        print(json.dumps(data, ensure_ascii=False))
        raise SystemExit(0)

    # Mode Excel
    tsv = to_tsv_excel_aligned(data, mapping)
    if not tsv.strip():
        raise SystemExit("TSV vide: aucune ligne extraite (parser ou mapping).")

    copy_to_clipboard(tsv)
    print("Copié dans le presse-papier. Colle dans Excel (Ctrl+V) en te mettant en colonne A.")


    # sorties optionnelles
    if args.out:
        out_dir = Path(args.out)
        out_dir.mkdir(parents=True, exist_ok=True)
        write_json(out_dir / (pdf_path.stem + ".json"), data)
        write_csv(out_dir / (pdf_path.stem + ".csv"), data)
        print(f"Fichiers écrits dans: {out_dir}")
