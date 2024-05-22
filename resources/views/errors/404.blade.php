<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ Storage::url('images/logo/favicon_c_new.png') }}">
    <title>404</title>
    <style>
        /* Variabel */
        :root {
            --col-sky-top: #bbcfe1;
            --col-sky-bottom: #e8f2f6;
            --col-fg: #5d7399;
            --col-blood: #dd4040;
            --col-ground: #f6f9fa;
        }

        /* Mixin */

        /* Styling */
        html,
        body {
            height: 100%;
            min-height: 450px;

            font-family: 'Dosis', sans-serif;
            font-size: 32px;
            font-weight: 500;
            color: var(--col-fg);
        }

        .content {
            height: 100%;
            position: relative;

            z-index: 1;
            background-color: mix(var(--col-sky-top), var(--col-sky-bottom));
            background-image: linear-gradient(to bottom, var(--col-sky-top) 0%, var(--col-sky-bottom) 80%);
            overflow: hidden;
        }

        .snow {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 20;
        }

        .main-text {
            padding: 20vh 20px 0 20px;

            text-align: center;
            line-height: 2em;
            font-size: 5vh;
        }

        @media (max-width: 768px) {
            .main-text {
                font-size: 2vh;
            }

            .home-link {
                font-size: 1vh;
            }
        }

        .home-link {
            font-size: 0.6em;
            font-weight: 400;
            color: inherit;
            text-decoration: none;

            opacity: 0.6;
            border-bottom: 1px dashed transparentize(var(--col-fg), 0.5);

            &:hover {
                opacity: 1;
            }
        }

        .ground {
            height: 160px;
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;

            background: var(--col-ground);
            box-shadow: 0 0 10px 10px var(--col-ground);

            --treeSize: 250px;
        }

        .ground:before,
        .ground:after {
            content: '';
            display: block;
            width: var(--treeSize);
            height: var(--treeSize);
            position: absolute;
            top: calc(-var(--treeSize)/4);

            z-index: -1;
            background: transparent;
            transform: scaleX(0.2) rotate(45deg);
        }

        .ground:after {
            left: 50%;
            margin-left: calc(-var(--treeSize) / 1.5);
            box-shadow: trees(-1, var(--treeSize));
        }

        .ground:before {
            right: 50%;
            margin-right: calc(-var(--treeSize) / 1.5);
            box-shadow: trees(1, var(--treeSize));
        }

        .mound {
            margin-top: -80px;

            font-weight: 800;
            font-size: 180px;
            text-align: center;
            color: var(--col-blood);
            pointer-events: none;

            --from-top: 50px;
        }

        .mound:before {
            --w: 600px;
            --h: 200px;

            content: '';
            display: block;
            width: var(--w);
            height: var(--h);
            position: absolute;
            left: 50%;
            margin-left: calc(-var(--w)/2);
            top: var(--from-top);
            z-index: 1;

            border-radius: 100%;
            background-color: var(--col-sky-bottom);
            background-image: linear-gradient(to bottom, lighten(var(--col-sky-top), 10%), var(--col-ground) 60px);
        }

        .mound:after {
            --w: 28px;
            --h: 6px;

            content: '';
            display: block;
            width: var(--w);
            height: var(--h);
            position: absolute;
            left: 50%;
            margin-left: - 150px;
            top: calc(var(--from-top) + 18px);

            z-index: 2;
            background: var(--col-blood);
            border-radius: 100%;
            transform: rotate(-15deg);
            box-shadow: calc(-var(--w) * 2) calc(var(--h) * 2) 0 1px var(--col-blood), calc(-var(--w) * 4.5) var(--h) 0 2px var(--col-blood), calc(-var(--w) * 7) calc(var(--h) * 4) 0 3px var(--col-blood);
        }

        .mound_text {
            transform: rotate(6deg);
        }

        .mound_spade {
            --handle-height: 30px;

            display: block;
            width: 35px;
            height: 30px;
            position: absolute;
            right: 50%;
            top: 42%;
            margin-right: -250px;

            z-index: 0;
            transform: rotate(35deg);
            background: var(--col-blood);
        }

        .mound_spade:before,
        .mound_spade:after {
            content: '';
            display: block;
            position: absolute;
        }

        .mound_spade:before {
            width: 40%;
            height: var(--handle-height);
            bottom: 98%;
            left: 50%;
            margin-left: -20%;

            background: var(--col-blood);
        }

        .mound_spade:after {
            width: 100%;
            height: 30px;
            top: calc(-var(--handle-height) - 25px);
            left: 0%;
            box-sizing: border-box;

            border: 10px solid var(--col-blood);
            border-radius: 4px 4px 20px 20px;
        }
    </style>
</head>

<body>
    <div class="content">
        <canvas class="snow" id="snow"></canvas>
        <div class="main-text">
            @if ($exception->getmessage() == null)
                <h1>Upss.<br>That page has gone missing.</h1>
            @else
                <h1>Upss.<br>{{ $exception->getmessage() }}</h1>
            @endif
            <a href="{{ url('/') }}" class="home-link">Hitch a ride back home.</a>
        </div>
        <div class="ground">
            <div class="mound">
                <div class="mound_text">404</div>
                <div class="mound_spade"></div>
            </div>
        </div>
    </div>

    <script>
        function trees(direction, size) {
            var shadow = [];

            for (var i = 1; i <= 16; i++) {
                var space = size * 1.2;
                var rand = ((Math.random() * 20) / 10 - 1) * 50; // Adjusted rand calculation

                shadow.push(
                    (direction * i * space + rand) + "px " + ((direction * -i * space) + rand) +
                    "px 15px lighten(var(--col-fg), " + (Math.floor(Math.random() * 20) + 10) + "%)"
                );
            }

            return shadow.join(", ");
        }

        (function() {
            function ready(fn) {
                if (document.readyState != 'loading') {
                    fn();
                } else {
                    document.addEventListener('DOMContentLoaded', fn);
                }
            }

            function createSnowEffect(canvas) {
                const ctx = canvas.getContext('2d');
                let width = 0;
                let height = 0;
                let particles = [];

                class Particle {
                    constructor() {
                        this.reset();
                    }

                    reset() {
                        this.y = Math.random() * height;
                        this.x = Math.random() * width;
                        this.dx = (Math.random() * 1) - 0.5;
                        this.dy = (Math.random() * 0.5) + 0.5;
                    }
                }

                function createParticles(count) {
                    if (count != particles.length) {
                        particles = [];
                        for (let i = 0; i < count; i++) {
                            particles.push(new Particle());
                        }
                    }
                }

                function onResize() {
                    width = window.innerWidth;
                    height = window.innerHeight;
                    canvas.width = width;
                    canvas.height = height;

                    createParticles((width * height) / 10000);
                }

                function updateParticles() {
                    ctx.clearRect(0, 0, width, height);
                    ctx.fillStyle = '#f6f9fa';

                    particles.forEach(function(particle) {
                        particle.y += particle.dy;
                        particle.x += particle.dx;

                        if (particle.y > height) {
                            particle.y = 0;
                        }

                        if (particle.x > width) {
                            particle.reset();
                            particle.y = 0;
                        }

                        ctx.beginPath();
                        ctx.arc(particle.x, particle.y, 5, 0, Math.PI * 2, false);
                        ctx.fill();
                    });

                    window.requestAnimationFrame(updateParticles);
                }

                onResize();
                updateParticles();

                window.addEventListener('resize', onResize);
            }

            ready(function() {
                const canvas = document.getElementById('snow');
                createSnowEffect(canvas);
            });
        })();
    </script>
</body>

</html>
