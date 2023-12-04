const search = document.querySelector(".search-box input"),
  imageGallery = document.getElementById("imageContainer"),
  paginationContainer = document.querySelector(".pagination-container"),
  viewAllButton = document.getElementById("viewAllButton");

const imagesPerPage = 3;

// Function to create image elements
function createImageElement(imageInfo) {
  const imageBox = document.createElement("div");
  imageBox.classList.add("image-box");

  const image = document.createElement("img");
  image.src = imageInfo.imagePath;
  image.alt = imageInfo.name;

  imageBox.appendChild(image);

  return imageBox;
}

// Function to render images based on the search value and page number
function renderImages(searchValue = "", pageNumber = 1) {
  imageGallery.innerHTML = "";
  fetch("./db.json") 
    .then((response) => response.json())
    .then((data) => {
      const filteredData = data.filter((imageInfo) => {
        const lowercasedName = imageInfo.name.toLowerCase();
        return lowercasedName.includes(searchValue.toLowerCase());
      });

      const startIndex = (pageNumber - 1) * imagesPerPage;
      const endIndex = startIndex + imagesPerPage;
      const pageImages = filteredData.slice(startIndex, endIndex);

      pageImages.forEach((imageInfo) => {
        const imageBox = createImageElement(imageInfo);
        imageGallery.appendChild(imageBox);
      });

      // Render pagination buttons only if there's a search query or more than one page
      if (searchValue !== "" || filteredData.length > imagesPerPage) {
        renderPaginationButtons(filteredData.length, pageNumber);
      } else {
        // Hide pagination container if there's no search query and only one page
        paginationContainer.style.display = "none";
      }
    })
    .catch((error) => console.error("Error fetching JSON:", error));
}

// Function to render pagination buttons
function renderPaginationButtons(totalImages, currentPage) {
  paginationContainer.innerHTML = ""; 

  const totalPages = Math.ceil(totalImages / imagesPerPage);

  for (let i = 1; i <= totalPages; i++) {
    const button = document.createElement("button");
    button.classList.add("pagination-button");
    if (i === currentPage) {
      button.classList.add("active");
    }
    button.textContent = i;

    // Event listener for pagination button click
    button.addEventListener("click", () => {
      renderImages(search.value, i);
    });

    paginationContainer.appendChild(button);
  }

  // Show pagination container
  paginationContainer.style.display = "flex";
}

// Event listener for search box keyup
search.addEventListener("keyup", (e) => {
  if (e.key === "Enter") {
    const searchValue = search.value.trim(); 
    renderImages(searchValue);
  }
});

// Event listener for "View All" button click
viewAllButton.addEventListener("click", () => {
    search.value = ""; 
    renderAllImages(); 
  });  
  // Function to render all images without filtering
  function renderAllImages() {
    imageGallery.innerHTML = ""; 
  
    fetch("./db.json")
      .then((response) => response.json())
      .then((data) => {
        data.forEach((imageInfo) => {
          const imageBox = createImageElement(imageInfo);
          imageGallery.appendChild(imageBox);
        });
  
        // Hide pagination container as we're displaying all images
        paginationContainer.style.display = "none";
      })
      .catch((error) => console.error("Error fetching JSON:", error));
  }

// Initial render with all images
renderImages();
