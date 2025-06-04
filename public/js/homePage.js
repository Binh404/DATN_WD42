// Modal functions
function openApplicationModal(jobTitle, jobId) {
    document.getElementById('modalJobTitle').textContent = `Ứng Tuyển: ${jobTitle}`;
    document.getElementById('applicationModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('applicationModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    document.getElementById('successMessage').style.display = 'none';
    document.getElementById('applicationForm').reset();
    document.getElementById('fileLabel').textContent = 'Chọn file CV (PDF, DOC, DOCX)';
}

// File upload handling
document.getElementById('cv').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const fileLabel = document.getElementById('fileLabel');
    
    if (file) {
        fileLabel.innerHTML = `
            <i class="fas fa-file-alt" style="color: #4ecdc4; margin-right: 0.5rem;"></i>
            ${file.name}
        `;
    } else {
        fileLabel.textContent = 'Chọn file CV (PDF, DOC, DOCX)';
    }
});

// Close modal when clicking outside
window.addEventListener('click', function(e) {
    const modal = document.getElementById('applicationModal');
    if (e.target === modal) {
        closeModal();
    }
});

// Progress bar animation
window.onscroll = function() {
    let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    let scrolled = (winScroll / height) * 100;
    document.getElementById("progressBar").style.width = scrolled + "%";
};

// Typed.js initialization for the hero section
document.addEventListener('DOMContentLoaded', function() {
    if(document.querySelector('.typed-text')) {
        let typed = new Typed('.typed-text', {
            strings: ["Phát triển sự nghiệp", "Khám phá cơ hội", "Thực hiện ước mơ"],
            typeSpeed: 50,
            backSpeed: 30,
            loop: true
        });
    }
});

// Smooth scroll for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Header scroll effect
let lastScrollTop = 0;
window.addEventListener('scroll', function() {
    const header = document.querySelector('header');
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > lastScrollTop) {
        header.style.transform = 'translateY(-100%)';
    } else {
        header.style.transform = 'translateY(0)';
    }
    
    lastScrollTop = scrollTop;
});

// Add floating animation to feature cards
document.querySelectorAll('.feature-card').forEach((card, index) => {
    card.style.animation = `float 3s ease-in-out infinite ${index * 0.5}s`;
});

// CSS for floating animation
const style = document.createElement('style');
style.textContent = `
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
`;
document.head.appendChild(style);

// Add parallax effect to hero section
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.hero');
    if (hero) {
        hero.style.transform = `translateY(${scrolled * 0.5}px)`;
    }
});

// Add hover effect to job cards
document.addEventListener('mouseover', function(e) {
    if (e.target.closest('.job-card')) {
        const card = e.target.closest('.job-card');
        card.style.transform = 'translateY(-10px) scale(1.02)';
    }
});

document.addEventListener('mouseout', function(e) {
    if (e.target.closest('.job-card')) {
        const card = e.target.closest('.job-card');
        card.style.transform = 'translateY(0) scale(1)';
    }
});

// Add form validation with real-time feedback
const inputs = document.querySelectorAll('input, textarea, select');
inputs.forEach(input => {
    input.addEventListener('blur', function() {
        if (this.hasAttribute('required') && !this.value.trim()) {
            this.style.borderColor = '#ff6b6b';
            this.style.boxShadow = '0 0 10px rgba(255, 107, 107, 0.3)';
        } else {
            this.style.borderColor = '#4ecdc4';
            this.style.boxShadow = '0 0 10px rgba(78, 205, 196, 0.3)';
        }
    });
});

// Add mobile menu toggle (for responsive design)
const createMobileMenu = () => {
    const nav = document.querySelector('nav');
    const menuBtn = document.createElement('button');
    menuBtn.innerHTML = '<i class="fas fa-bars"></i>';
    menuBtn.style.cssText = `
        display: none;
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        @media (max-width: 768px) { display: block; }
    `;
    
    const navLinks = document.querySelector('.nav-links');
    
    menuBtn.addEventListener('click', () => {
        navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
        navLinks.style.flexDirection = 'column';
        navLinks.style.position = 'absolute';
        navLinks.style.top = '100%';
        navLinks.style.left = '0';
        navLinks.style.right = '0';
        navLinks.style.background = 'rgba(255, 255, 255, 0.1)';
        navLinks.style.backdropFilter = 'blur(20px)';
        navLinks.style.padding = '1rem';
    });
    
    nav.appendChild(menuBtn);
};

// Initialize mobile menu
createMobileMenu();