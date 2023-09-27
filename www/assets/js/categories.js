document.addEventListener("DOMContentLoaded", function () {
  const categoryFilter = document.getElementById("categoryFilter");

  categoryFilter.addEventListener("change", function () {
    const selectedCategory = this.options[this.selectedIndex].text;
    if (selectedCategory !== "All Categories") {
      window.location.href = `/blog/${selectedCategory}`;
    } else {
      window.location.href = "/";
    }
  });
});
