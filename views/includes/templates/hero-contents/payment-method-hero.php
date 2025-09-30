<div class="hero-title">
    <div class="main-title">ADD <span class="highlight">CARD</span> PAYMENT</div>
    <div class="subtitle">PAYMENT</div>
</div>
<div class="button-group">
    <button class="btn-outline btn-add-card">Add Card</button>
    <a href="checkout-details.php" class="btn-primary btn-payment-method">Payment Method</a>
</div>

<style>
/* Specific styles for payment-method hero content */
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

.button-group {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.btn-outline {
    background: white;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
    padding: 15px 100px;
    font-size: 1.2rem;
    font-weight: 400;
    border-radius: 12px;
    cursor: pointer;
    transition: var(--transition);
    height: 3.9rem;
}

.btn-outline:hover {
    background: rgba(86, 79, 253, 0.05);
    transform: translateY(-2px);
}

@media (max-width: 992px) {
    .hero-title .main-title {
        font-size: 3.5rem;
    }
    
    .hero-title .subtitle {
        font-size: 2rem;
    }

    .button-group {
        flex-direction: column;
    }

    .btn-outline,
    .btn-primary {
        width: 100%;
        padding: 12px 40px;
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