document.addEventListener("DOMContentLoaded", () => {
  // Redirects based on the current page type
  const proContainers = document.querySelectorAll(".pro-container");
  proContainers.forEach((proContainer) => {
    proContainer.addEventListener("click", (event) => {
      const clickedPro = event.target.closest(".pro");
      const currentPage = proContainer.dataset.page;
      if (clickedPro && currentPage) {
        const pageRedirectionMap = {
          index: "shop.html",
          index1: "shop.html",
          shop: "sproduct.html",
          sproduct: "shop.html",
        };
        window.location.href = pageRedirectionMap[currentPage] || "#";
      }
    });
  });

  // Replaces the big image with the clicked small image in the product page
  const MainImg = document.querySelector("#MainImg");
  const smallImages = document.querySelectorAll(".small-img");
  if (MainImg && smallImages.length > 0) {
    smallImages.forEach((smallImg) => {
      smallImg.addEventListener("click", () => {
        MainImg.src = smallImg.src;
      });
    });
  }

  // Redirects from the 'Shop Now' button to shop.html
  const shopNowButton = document.querySelector("#btn");
  if (shopNowButton) {
    shopNowButton.addEventListener("click", () => {
      window.location.href = "shop.html";
    });
  }

  // Pagination logic: redirects between pages
  const paginationMap = {
    page1: "shop1.html",
    page2: "shop2.html",
    page3: "shop3.html",
    next: "shop2.html", // Example logic for "Next" button
  };
  Object.keys(paginationMap).forEach((id) => {
    const pageElement = document.querySelector(`#${id}`);
    if (pageElement) {
      pageElement.addEventListener("click", () => {
        window.location.href = paginationMap[id];
      });
    }
  });

  // Filtering and Sorting Products
  const categorySelect = document.getElementById("category");
  const priceSelect = document.getElementById("price");
  const products = document.querySelectorAll(".pro");

  if (categorySelect && priceSelect && products.length > 0) {
    function filterAndSortProducts() {
      const selectedCategory = categorySelect.value;
      const selectedSort = priceSelect.value;

      const productArray = Array.from(products);

      // Filter by category
      productArray.forEach((product) => {
        const category = product.getAttribute("data-category");
        product.style.display =
          selectedCategory === "all" || category === selectedCategory
            ? "block"
            : "none";
      });

      // Sort by price
      if (selectedSort !== "default") {
        productArray.sort((a, b) => {
          const priceA = parseInt(a.getAttribute("data-price"));
          const priceB = parseInt(b.getAttribute("data-price"));
          return selectedSort === "lowToHigh" ? priceA - priceB : priceB - priceA;
        });

        const container = document.querySelector(".pro-container");
        productArray.forEach((product) => container.appendChild(product));
      }
    }

    categorySelect.addEventListener("change", filterAndSortProducts);
    priceSelect.addEventListener("change", filterAndSortProducts);
  }
});
