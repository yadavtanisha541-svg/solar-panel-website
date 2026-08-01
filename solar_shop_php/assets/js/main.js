/* ==========================================================================
   Solar Panel Shop - Main JavaScript
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Initialize Animate On Scroll (AOS)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
    }

    // 2. Animated Counter
    const counters = document.querySelectorAll('.stat-number');
    const speed = 200;

    if (counters.length > 0) {
        const runCounter = () => {
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText.replace(/[^0-9]/g, '');
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc) + (counter.getAttribute('data-suffix') || '');
                    setTimeout(runCounter, 15);
                } else {
                    counter.innerText = target + (counter.getAttribute('data-suffix') || '');
                }
            });
        };

        // Trigger counter when in viewport
        let observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    runCounter();
                    observer.disconnect();
                }
            });
        }, { threshold: 0.5 });

        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            observer.observe(statsSection);
        }
    }

    // 3. Solar ROI Calculator
    const monthlyBillInput = document.getElementById('calcMonthlyBill');
    if (monthlyBillInput) {
        const calcBtn = document.getElementById('calculateRoiBtn');
        calcBtn.addEventListener('click', function () {
            const bill = parseFloat(monthlyBillInput.value);
            if (isNaN(bill) || bill <= 0) {
                alert('Please enter a valid monthly bill amount.');
                return;
            }

            // Calculations based on typical Indian solar tariff rates (80-90% savings)
            const recommendedKw = (bill / 1200).toFixed(1);
            const monthlySavings = Math.round(bill * 0.88);
            const yearlySavings = monthlySavings * 12;
            const savings25Years = yearlySavings * 25;

            document.getElementById('resKw').innerText = recommendedKw + ' kW';
            document.getElementById('resMonthly').innerText = '₹' + monthlySavings.toLocaleString('en-IN');
            document.getElementById('resYearly').innerText = '₹' + yearlySavings.toLocaleString('en-IN');
            document.getElementById('res25Years').innerText = '₹' + savings25Years.toLocaleString('en-IN');

            document.getElementById('roiResults').style.display = 'block';
        });
    }

    // 4. Projects Category Filter
    const filterButtons = document.querySelectorAll('.gallery-filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function () {
                filterButtons.forEach(btn => btn.classList.remove('active', 'btn-solar-primary'));
                filterButtons.forEach(btn => btn.classList.add('btn-solar-outline'));

                this.classList.remove('btn-solar-outline');
                this.classList.add('active', 'btn-solar-primary');

                const filter = this.getAttribute('data-filter');

                galleryItems.forEach(item => {
                    if (filter === 'all' || item.classList.contains(filter)) {
                        item.style.display = 'block';
                        item.classList.add('animate__fadeIn');
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    // 5. Image Lightbox Modal Handler
    const projectCards = document.querySelectorAll('.project-lightbox');
    const modalImage = document.getElementById('lightboxModalImage');
    const modalTitle = document.getElementById('lightboxModalTitle');
    
    if (projectCards.length > 0 && modalImage) {
        projectCards.forEach(card => {
            card.addEventListener('click', function (e) {
                e.preventDefault();
                const imgSrc = this.getAttribute('href') || this.getAttribute('data-img');
                const title = this.getAttribute('data-title') || 'Solar Installation';
                modalImage.src = imgSrc;
                if (modalTitle) modalTitle.innerText = title;
                
                const bsModal = new bootstrap.Modal(document.getElementById('lightboxModal'));
                bsModal.show();
            });
        });
    }
});
