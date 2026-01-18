import re
import json
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
# Parsing
# =========================
def clean_acheteur(raw: str) -> str:
    return re.split(r"\s{2,}", raw.strip(), maxsplit=1)[0].strip()

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

        for i in range(1, qte + 1):
            row2 = row.copy()
            row2["poste"] = f"{base_poste}-{str(i)}"
            row2["quantite"] = "1"
            out.append(row2)

    return out

def parse_pdf(pdf_path: Path, debug: bool = False) -> dict:
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

            row = {
                "poste": int(poste),  # (ou str si tu fais le .1/.2 après)
                "code_article": code,
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
# CLI
# =========================
if __name__ == "__main__":
    import argparse

    ap = argparse.ArgumentParser()
    ap.add_argument("pdf", help="Chemin du PDF")
    ap.add_argument("--debug", action="store_true")
    args = ap.parse_args()

    pdf_path = Path(args.pdf)
    if not pdf_path.exists():
        raise SystemExit(f"PDF introuvable: {pdf_path}")

    try:
        data = parse_pdf(pdf_path, debug=args.debug)
        validate_parse(data)
    except ManualParseRequired as e:
        print(f"[MANUAL] {pdf_path.name} → {e}")
        raise SystemExit(2)

    print(json.dumps(data, ensure_ascii=False))
