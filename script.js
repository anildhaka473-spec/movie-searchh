document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("searchForm");
    const input = document.getElementById("movieInput");
    const result = document.getElementById("result");
    const button = document.getElementById("searchButton");


    if (!form || !input || !result) {
        return;
    }


    form.addEventListener("submit", async (event) => {

        event.preventDefault();


        const movie = input.value.trim();


        if (!movie) {

            showMessage(
                "Please enter a movie name.",
                "⚠️"
            );

            input.focus();

            return;
        }


        if (movie.length > 100) {

            showMessage(
                "Movie name is too long.",
                "⚠️"
            );

            return;
        }


        button.disabled = true;

        button.textContent = "Searching...";


        result.innerHTML = `
            <div class="loading-state">

                <div class="loader"></div>

                <h2>Searching...</h2>

                <p>Finding your movie</p>

            </div>
        `;


        try {

            const response = await fetch(
                "search.php?movie=" +
                encodeURIComponent(movie),
                {
                    method: "GET",
                    headers: {
                        "Accept": "text/html"
                    }
                }
            );


            if (!response.ok) {
                throw new Error(
                    `HTTP error: ${response.status}`
                );
            }


            const html = await response.text();


            if (!html.trim()) {

                throw new Error(
                    "Empty server response"
                );
            }


            result.innerHTML = html;


            result.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });


        } catch (error) {

            console.error(
                "Movie search error:",
                error
            );


            showMessage(
                "Unable to search right now. Please try again.",
                "⚠️"
            );

        } finally {

            button.disabled = false;

            button.textContent = "Search";

        }

    });


    function showMessage(message, icon) {

        result.innerHTML = `
            <div class="empty-state">

                <div class="empty-icon">
                    ${icon}
                </div>

                <h2>
                    ${escapeHTML(message)}
                </h2>

            </div>
        `;

    }


    function escapeHTML(value) {

        const div =
            document.createElement("div");

        div.textContent = value;

        return div.innerHTML;
    }

});
