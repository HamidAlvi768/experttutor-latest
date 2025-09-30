<div class="hero-title">
    <div class="main-title">ADD <span class="highlight">CARD</span> PAYMENT</div>
    <div class="subtitle">PAYMENT</div>
</div>
<button class="btn-primary btn-add-card">Add Card</button>

<style>
/* Specific styles for add-card hero content */
.hero-title {
    font-size: 4rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 20px;
    text-transform: uppercase;
    text-align: center;
}

.hero-title .main-title {
    white-space: nowrap;
    font-size: 4.5rem;
    letter-spacing: 2px;
}

.hero-title .highlight {
    color: var(--primary-color);
}

.hero-title .subtitle {
    font-size: 2rem;
    margin-top: 10px;
    font-weight: 400;
    letter-spacing: 2px;
    text-align: center;
}

.btn-add-card {
    margin-bottom: 20px;
}

@media (max-width: 992px) {
    .hero-title .main-title {
        font-size: 3.5rem;
    }
    
    .hero-title .subtitle {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .hero-title .main-title {
        font-size: 2.5rem;
        white-space: normal;
    }
    
    .hero-title .subtitle {
        font-size: 1.8rem;
    }
}
</style> 