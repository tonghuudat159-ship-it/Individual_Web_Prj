/**
 * Search Functionality
 * Handles AJAX course search from the navbar
 */

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("courseSearchInput");
  const searchResults = document.getElementById("searchResults");

  if (!searchInput || !searchResults) {
    return;
  }

  const searchWrapper = searchInput.closest(".navbar-search");
  let debounceTimer = null;
  let requestCounter = 0;

  function hideResults() {
    searchResults.innerHTML = "";
    searchResults.classList.remove("visible");
  }

  function showMessage(message, cssClass) {
    searchResults.innerHTML =
      '<div class="search-results-message ' + cssClass + '">' + message + "</div>";
    searchResults.classList.add("visible");
  }

  function formatPrice(price) {
    const amount = Number(price || 0);
    return amount.toLocaleString("vi-VN") + " VND";
  }

  function escapeHtml(value) {
    return String(value)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  function renderResults(results) {
    if (!Array.isArray(results) || results.length === 0) {
      showMessage("No courses found.", "empty");
      return;
    }

    const itemsHtml = results
      .map(function (course) {
        const title = escapeHtml(course.title || "Untitled Course");
        const instructor = escapeHtml(
          course.instructor_name || "DatEdu Instructor"
        );
        const category = escapeHtml(course.category_name || "Course");
        const rating = escapeHtml(course.rating || "0.0");
        const price = escapeHtml(formatPrice(course.price));
        const href =
          "course-detail.php?slug=" + encodeURIComponent(course.slug || "");

        return (
          '<a class="search-result-item" href="' +
          href +
          '">' +
          '<div class="search-result-text">' +
          '<span class="search-result-title">' +
          title +
          "</span>" +
          '<span class="search-result-meta">' +
          instructor +
          " - " +
          category +
          "</span>" +
          "</div>" +
          '<div class="search-result-side">' +
          '<span class="search-result-rating">&#9733; ' +
          rating +
          "</span>" +
          '<span class="search-result-price">' +
          price +
          "</span>" +
          "</div>" +
          "</a>"
        );
      })
      .join("");

    searchResults.innerHTML = itemsHtml;
    searchResults.classList.add("visible");
  }

  async function runSearch(query) {
    const requestId = ++requestCounter;
    showMessage("Searching...", "loading");

    try {
      const response = await fetch(
        "ajax/search_courses.php?q=" + encodeURIComponent(query),
        {
          headers: {
            Accept: "application/json",
          },
        }
      );

      const data = await response.json();

      if (requestId !== requestCounter) {
        return;
      }

      if (!data.success) {
        showMessage("Search failed.", "error");
        return;
      }

      renderResults(data.results || []);
    } catch (error) {
      if (requestId !== requestCounter) {
        return;
      }

      showMessage("Search failed.", "error");
    }
  }

  searchInput.addEventListener("input", function () {
    const query = searchInput.value.trim();

    clearTimeout(debounceTimer);

    if (query.length < 2) {
      requestCounter++;
      hideResults();
      return;
    }

    debounceTimer = setTimeout(function () {
      runSearch(query);
    }, 300);
  });

  searchInput.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      hideResults();
    }
  });

  document.addEventListener("click", function (event) {
    if (!searchWrapper || searchWrapper.contains(event.target)) {
      return;
    }

    hideResults();
  });
});
