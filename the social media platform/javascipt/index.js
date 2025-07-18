document.addEventListener('DOMContentLoaded', function() {
    const feed = document.getElementById('feed');
    
    const posts = [
        { text: 'Just got a new vibe! #blessed' },
        { text: 'Feeling fresh and ready to take on the world!' },
        { text: 'Learning to code and loving it!' }
    ];
    
    posts.forEach(post => {
        const postElement = document.createElement('div');
        postElement.classList.add('col-md-4', 'mb-4');
        postElement.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <p class="card-text">${post.text}</p>
                </div>
            </div>
        `;
        feed.appendChild(postElement);
    });
});
