<div id="app"></div>

<script type="text/javascript">
    fetch('/users/1').then(function (response) {
        return response.json();
    }).then(function (user) {
        document.querySelector('#app').innerHTML = `
            <div id="user">
                <p class="name">${user.name}</p>
                <p class="email">${user.email}</p>
            </div>
        `;
    });
</script>