function trees(direction, size) {
    var shadow = [];

    for (var i = 1; i <= 16; i++) {
        var space = size * 1.2;
        var rand = ((Math.random() * 20) / 10 - 1) * 50; // Adjusted rand calculation

        shadow.push(
            direction * i * space +
                rand +
                "px " +
                (direction * -i * space + rand) +
                "px 15px lighten(var(--col-fg), " +
                (Math.floor(Math.random() * 20) + 10) +
                "%)"
        );
    }

    return shadow.join(", ");
}

(function () {
    function ready(fn) {
        if (document.readyState != "loading") {
            fn();
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    function createSnowEffect(canvas) {
        const ctx = canvas.getContext("2d");
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
                this.dx = Math.random() * 1 - 0.5;
                this.dy = Math.random() * 0.5 + 0.5;
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
            ctx.fillStyle = "#f6f9fa";

            particles.forEach(function (particle) {
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

        window.addEventListener("resize", onResize);
    }

    ready(function () {
        const canvas = document.getElementById("snow");
        createSnowEffect(canvas);
    });
})();
