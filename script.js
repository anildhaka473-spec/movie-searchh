document.addEventListener("DOMContentLoaded", () => {

    const searchForm = document.getElementById("searchForm");
    const movieInput = document.getElementById("movieInput");
    const result = document.getElementById("result");

    if (!searchForm || !movieInput || !result) {
        return;
    }


    searchForm.addEventListener("submit", async (event) => {

        event.preventDefault();

        const movie = movieInput.value.trim();

        if (!movie) {
            showMessage("Please enter a movie name.");
            return;
        }


        showLoading();


        try {

            const response = await fetch(
                `search.php?movie=${encodeURIComponent(movie)}`
            );


            if (!response.ok) {
                throw new Error("Server error");
            }


            const html = await response.text();

            result.innerHTML = html;

            result.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });


        } catch (error) {

            console.error(error);

            showMessage(
                "Something went wrong. Please try again."
            );

        }

    });


    function showLoading() {

        result.innerHTML = `
            <div class="loading-state">

                <div class="loader"></div>

                <h2>Searching...</h2>

                <p>Finding your movie</p>

            </div>
        `;
    }


    function showMessage(message) {

        result.innerHTML = `
            <div class="empty-state">

                <div class="empty-icon">⚠️</div>

                <h2>${escapeHTML(message)}</h2>

            </div>
        `;
    }


    function escapeHTML(text) {

        const div = document.createElement("div");

        div.textContent = text;

        return div.innerHTML;
    }

});
