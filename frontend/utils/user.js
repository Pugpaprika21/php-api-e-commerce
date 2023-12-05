export function saveUserLogin(user) {
    const detail = user.Detail;
    const roles = user.Roles;
    sessionStorage.setItem("Id", detail.Id);
    sessionStorage.setItem("Roles", roles);
}

export function checkUserLogin() {
    if (sessionStorage.getItem("Id") == null) {
        window.location.href = "/e-commerce/login";
        return;
    }
}

export function checkAdminPage(roles) {
    // admin
    if (!roles.includes("2")) {
        sessionStorage.clear();
        //router.push({ name: "login" });
        window.location.href = "/e-commerce/login";
        return;
    }
}