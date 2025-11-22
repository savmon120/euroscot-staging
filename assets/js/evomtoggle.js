function toggleAll(expand) {
  document.querySelectorAll('.dropdown-content').forEach(content => {
    if (expand) {
      content.classList.add('open');
    } else {
      content.classList.remove('open');
    }
  });
}

function searchEVOM() {
  const query = document.getElementById('evomSearch').value.toLowerCase();
  const boxes = document.querySelectorAll('.dropdown-box');
  const contents = document.querySelectorAll('.dropdown-content');

  boxes.forEach((box, index) => {
    const content = contents[index];
    const combinedText = box.textContent.toLowerCase() + content.textContent.toLowerCase();
    const match = combinedText.includes(query);

    box.style.display = match ? 'block' : 'none';
    content.style.display = match ? 'block' : 'none';

    if (match) {
      content.classList.add('open');
    } else {
      content.classList.remove('open');
    }
  });
}