const cpyBtn = document.getElementById('cpyBtn');
cpyBtn.addEventListener('click', copyIds);

const clrBtn = document.querySelector('.clearBtn');
clrBtn.addEventListener('click', clearResults);

function getIds() {
  const url = './generate.php';

  fetch(url, {
    method: 'POST',
    body: new FormData(document.getElementById('inputform')),
  })
    .then(
      (response) => response.text() // .json(), etc.
    )
    .then((html) => {
      document.getElementById('results').innerHTML = html;
      document.getElementById('txt').value = html.replace(/<br \/>/g, '\n');
      document.querySelector('.clearBtn').classList.remove('hidden');
      document.getElementById('cpyBtn').classList.add('active');
      document.querySelector('.copyres').innerHTML = '';
    });
}

function copyIds(e) {
  console.log();
  let btn = document.getElementById('cpyBtn');
  if (btn.classList.contains('active')) {
    if (navigator && navigator.clipboard && navigator.clipboard.writeText) {
      const uuids = document.getElementById('txt').value;
      navigator.clipboard.writeText(uuids);
    } else {
      window
        .getSelection()
        .selectAllChildren(document.getElementById('results'));
      document.execCommand('copy');
      clearSelection();
    }
    document.querySelector('.copyres').innerHTML = 'Copied!';
  }
}

function clearSelection() {
  if (window.getSelection) {
    if (window.getSelection().empty) {
      // Chrome
      window.getSelection().empty();
    } else if (window.getSelection().removeAllRanges) {
      // Firefox
      window.getSelection().removeAllRanges();
    }
  } else if (document.selection) {
    // IE?
    document.selection.empty();
  }
}

function clearResults() {
  document.getElementById('results').innerHTML = '';
  document.getElementById('txt').value = '';
  document.querySelector('.clearBtn').classList.add('hidden');
  document.getElementById('cpyBtn').classList.remove('active');
  document.querySelector('.copyres').innerHTML = '';
}
