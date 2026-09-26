
document.addEventListener('DOMContentLoaded', () => {
    const healthTipContainer = document.getElementById('api-health-tips');

    if (healthTipContainer) {
        // Fetch public health advice/quotes API
        fetch('https://dummyjson.com/quotes/random')
            .then(response => response.json())
            .then(data => {
                healthTipContainer.innerHTML = `
                    <div style="background: #252525; padding: 1.5rem; border-left: 4px solid #0d6efd; border-radius: 4px;">
                        <p style="font-style: italic; font-size: 1.1rem; color: #e0e0e0;">"${data.quote}"</p>
                        <small style="color: #0d6efd; display: block; margin-top: 0.5rem;">— ${data.author} (Daily Health Insight)</small>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error fetching API data:', error);
                healthTipContainer.innerHTML = '<p>Sunrise Hospital: Dedicated to high quality, evidence-based healthcare excellence.</p>';
            });
    }
});