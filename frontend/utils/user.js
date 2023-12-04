export function saveUserLogin(user) {
    const detail = user.Detail;
    const roles = user.Roles;
    localStorage.setItem("Id", detail.Id);
    localStorage.setItem("Roles", roles);
}

export function checkUserLogin() {
    if (localStorage.getItem("Id") == null) {
        window.location.href = "/e-commerce/login";
        return;
    }
}

export function checkAdminPage(roles) {
    // admin
    if (!roles.includes("2")) {
        localStorage.clear();
        //router.push({ name: "login" });
        window.location.href = "/e-commerce/login";
        return;
    }
}