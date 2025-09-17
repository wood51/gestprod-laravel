<!DOCTYPE html>
<html lang="fr" class="h-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestprod')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen flex flex-col">
    <!-- HEADER + progress bar -->
    <header class="flex-none relative">
        <!-- Header -->
        <div class="navbar h-18 flex justify-between bg-gray-700">
            <!-- Logo -->
            <div class="flex flex-col items-center cursor-pointer ml-4 m-y-1">
                <div class="flex items-center gap-2">
                    <a href="/"><img src="{{ asset('img/gears.svg') }}" width="50" alt="Logo GestProd" /></a>
                    <a href="/"><span
                            class="text-xl sm:text-3xl font-semibold text-indigo-400">GESTPROD</span></a>
                </div>
                <!-- <a href="/"><span class="text-base text-gray-500 text-center font-semibold italic">Gestion de production DEE</span></a> -->
            </div>
            <!-- Clock -->
            <div class="flex items-center gap-2 text-2xl text-white font-semibold mr-4">
                <span id="clock" class=" ">12:00</span>
                <!-- <i class="far fa-calendar-days"></i> -->
                <!-- change week-dd and --week-dd-anchor names. Use unique names for each dropdown -->
                {{-- <button class="btn btn-ghost" popovertarget="week-dd" style="anchor-name: --week-dd-anchor">
                    <i class="far fa-calendar-days text-2xl cursor-pointer"></i>
                </button>
                <ul class="dropdown dropdown-bottom dropdown-end menu w-52 rounded-box bg-base-100" popover
                    id="week-dd" style="position-anchor: --week-dd-anchor">
                    <li>
                        <input type="week" value="{{ @week_picker }}" max="{{ @max_week_picker }}" min="2024-W45"
                            class="input text-black bg-base-100" name="semaine" hx-trigger="change"
                            hx-post="/public/dashboard/set-date" hx-include="this" />
                    </li>
                </ul> --}}
            </div>
        </div>
        <!-- Clock Script -->
        <script>
            function updateTime() {
                const now = new Date();
                const options = {
                    hour: "2-digit",
                    minute: "2-digit"
                };
                const formattedTime = now.toLocaleTimeString("fr-FR", options);
                document.querySelector("#clock").textContent = formattedTime;
            }
            setInterval(updateTime, 1000);
            updateTime();
        </script>
        <div class="w-full h-1.5 bg-base-200">
            <div id="progress-fill" class="h-full bg-warning w-0"></div>
        </div>
    </header>

    <!-- CAROUSEL -->
    <main class="flex-1 overflow-hidden">
        <div id="carousel" class="carousel w-full h-full overflow-hidden">
            <!-- Slide 1 -->
            <div id="slide1" class="carousel-item relative w-full h-full">
                @include('kpi.partials.engagement-type')
            </div>
            <!-- Slide 2 -->
            <div id="slide2" class="carousel-item relative w-full h-full">
                @include('kpi.partials.engagement')  
            </div> 
            <!-- Slide 3 -->
            <div id="slide3" class="carousel-item relative w-full h-full">
                @include('kpi.partials.performance-qualite');
            </div> 
        </div>
    </main>

    <!-- Indicateur flottant Pause/Play -->
    <div id="pauseIndicator"
        class="fixed invisible bottom-4 right-4 bg-gray-800 text-white p-2 rounded shadow-lg flex items-center gap-2 z-50">
        <span id="pauseIcon" class="text-xl">⏸</span>
        <span id="pauseText">Pause</span>
    </div>

     <script>
      document.addEventListener("DOMContentLoaded", () => {
        const carousel = document.getElementById("carousel");
        const slides = Array.from(carousel.querySelectorAll(".carousel-item"));
        const bar = document.getElementById("progress-fill");
        const indicator = document.getElementById("pauseIndicator");
        const icon = document.getElementById("pauseIcon");
        const text = document.getElementById("pauseText");
        let current = 0,
          paused = false,
          timer,
          hideTimeout;

        // Affiche la slide d'index i
        function showSlide(i) {
          slides[i].scrollIntoView({ behavior: "smooth", inline: "start" });
          current = i;
        }

        // Passe à la slide suivante
        function nextSlide() {
          showSlide((current + 1) % slides.length);
          resetProgress();
        }

        // Réinitialise et relance l'animation de la barre
        function resetProgress() {
          bar.style.transition = "none";
          bar.style.width = "0";
          setTimeout(() => {
            bar.style.transition = "width 30s linear";
            bar.style.width = "100%";
          }, 50);
        }

        // Démarre le défilement auto
        function startTimer() {
          timer = setInterval(nextSlide, 30000);
          resetProgress();
        }

        // Arrête le défilement auto (garde la barre où elle est)
        function stopTimer() {
          clearInterval(timer);
          bar.style.transition = "";
        }

        // Affiche brièvement l'indicateur pause/play
        function showIndicator() {
          clearTimeout(hideTimeout);
          indicator.classList.remove("invisible");
          hideTimeout = setTimeout(() => {
            indicator.classList.add("invisible");
          }, 2000);
        }

        // Initialisation
        showSlide(0);
        startTimer();

        document.addEventListener("keydown", (e) => {
          // Espace : change de slide sans toucher au mode pause
          if (e.code === "Space") {
            e.preventDefault();
            if (paused) {
              showSlide((current + 1) % slides.length);
            } else {
              nextSlide();
            }
          }
          // P : toggle pause/play et affiche l'indicateur
          if (e.code === "KeyP") {
            e.preventDefault();
            paused = !paused;
            if (paused) {
              stopTimer();
              icon.textContent = "⏸";
              text.textContent = "Pause";
            } else {
              startTimer();
              icon.textContent = "▶️";
              text.textContent = "Play";
            }
            showIndicator();
          }
        });
      });

      document.addEventListener("reload-page", function () {
        location.reload();
      });
    </script> 
</body>

</html>
