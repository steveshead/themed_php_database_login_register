const aside = document.querySelector('aside');
if (window.innerWidth < 1000 || localStorage.getItem('admin_menu') == 'minimal') {
    aside.classList.add('minimal');
}
if (window.innerWidth < 1000) {
    document.addEventListener('click', event => {
        if (!aside.classList.contains('minimal') && !event.target.closest('aside') && !event.target.closest('.responsive-toggle') && window.innerWidth < 1000) {
            aside.classList.add('minimal');
        }
    });
}
window.addEventListener('resize', () => {
    if (window.innerWidth < 1000) {
        aside.classList.add('minimal');
    } else if (localStorage.getItem('admin_menu') == 'normal') {
        aside.classList.remove('minimal');
    }
});
document.querySelector('.responsive-toggle').onclick = event => {
    event.preventDefault();
    if (aside.classList.contains('minimal')) {
        aside.classList.remove('minimal');
        localStorage.setItem('admin_menu', 'normal');
    } else {
        aside.classList.add('minimal');
        localStorage.setItem('admin_menu', 'minimal');
    }
};
document.querySelectorAll('.tabs a').forEach((tab_link, tab_link_index) => {
    tab_link.onclick = event => {
        event.preventDefault();
        document.querySelectorAll('.tabs a').forEach(tab_link => tab_link.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach((tab_content, tab_content_index) => {
            if (tab_link_index == tab_content_index) {
                tab_link.classList.add('active');
                tab_content.style.display = 'block';
            } else {
                tab_content.style.display = 'none';
            }
        });
    };
});
if (document.querySelector('.filters a')) {
    let filtersList = document.querySelector('.filters .list');
    let filtersListStyle = window.getComputedStyle(filtersList);
    document.querySelector('.filters a').onclick = event => {
        event.preventDefault();
        if (filtersListStyle.display == 'none') {
            filtersList.style.display = 'flex';
        } else {
            filtersList.style.display = 'none';
        }
    };
    document.addEventListener('click', event => {
        if (!event.target.closest('.filters')) {
            filtersList.style.display = 'none';
        }
    });
}
document.querySelectorAll('.table-dropdown').forEach(dropdownElement => {
    dropdownElement.onclick = event => {
        event.preventDefault();
        let dropdownItems = dropdownElement.querySelector('.table-dropdown-items');
        let contextMenu = document.querySelector('.table-dropdown-items-context-menu');
        if (!contextMenu) {
            contextMenu = document.createElement('div');
            contextMenu.classList.add('table-dropdown-items', 'table-dropdown-items-context-menu');
            document.addEventListener('click', event => {
                if (contextMenu.classList.contains('show') && !event.target.closest('.table-dropdown-items-context-menu') && !event.target.closest('.table-dropdown')) {
                    contextMenu.classList.remove('show');
                }
            });
        }
        contextMenu.classList.add('show');
        contextMenu.innerHTML = dropdownItems.innerHTML;
        contextMenu.style.position = 'absolute';
        let width = window.getComputedStyle(dropdownItems).width ? parseInt(window.getComputedStyle(dropdownItems).width) : 0;
        contextMenu.style.left = (event.pageX-width) + 'px';
        contextMenu.style.top = event.pageY + 'px';
        document.body.appendChild(contextMenu);
    };
});
document.querySelectorAll('.msg').forEach(element => {
    element.querySelector('.close').onclick = () => {
        element.remove();
        history.replaceState && history.replaceState(null, '', location.pathname + location.search.replace(/[\?&]success_msg=[^&]+/, '').replace(/^&/, '?') + location.hash);
        history.replaceState && history.replaceState(null, '', location.pathname + location.search.replace(/[\?&]error_msg=[^&]+/, '').replace(/^&/, '?') + location.hash);
    };
});
if (location.search.includes('success_msg') || location.search.includes('error_msg')) {
    history.replaceState && history.replaceState(null, '', location.pathname + location.search.replace(/[\?&]success_msg=[^&]+/, '').replace(/^&/, '?') + location.hash);
    history.replaceState && history.replaceState(null, '', location.pathname + location.search.replace(/[\?&]error_msg=[^&]+/, '').replace(/^&/, '?') + location.hash);
}