const sideMenu = document.querySelector('aside');
const menuBtn = document.getElementById('menu-btn');
const closeBtn = document.getElementById('close-btn');

const darkMode = document.querySelector('.dark-mode');

menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
});

closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
});

darkMode.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode-variables');
    darkMode.querySelector('span:nth-child(1)').classList.toggle('active');
    darkMode.querySelector('span:nth-child(2)').classList.toggle('active');
})



function toggle(){
    var blur = document.getElementById('blur');
    blur.classList.toggle('active');
    var popup = document.getElementById('popup');
    popup.classList.toggle('active');
}

const roleSelect = document.getElementById('user_type');
const adminTypeField = document.getElementById('admintypefield');

function toggleAdminField() {
    if (roleSelect.value === 'admin') {
        adminTypeField.style.display = 'flex'; // Show the admin type field
    } else {
        adminTypeField.style.display = 'none'; // Hide the admin type field
    }
}

// Add event listener to roleSelect to detect changes
roleSelect.addEventListener('change', toggleAdminField);

// Initial check to set the visibility on page load
toggleAdminField();