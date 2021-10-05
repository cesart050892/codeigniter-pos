var base_url = window.location.origin + "/";

function logout() {
  $.ajax({
    type: "GET",
    url: base_url + "api/me/logout",
    success: function (response) {
      localStorage.removeItem("idUser");
      location.reload(true);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      Swal.fire("Error!", "Server error!", "error");
    },
  });
}

$(".logout").on("click", function () {
  Swal.fire({
    title: "Ready to Leave?",
    text: "End your current session.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Logout",
  }).then((result) => {
    if (result.isConfirmed) {
      logout();
    }
  });
});

function getProfile() {
  $.get(base_url + "api/me", (resp) => {
    let user = resp.data;
    localStorage.setItem("idUser", user.id);
    !user.surname
      ? $(".profile-name").text(user.name)
      : $(".profile-name").text(`${user.name} ${user.surname}`);
  });
}

getProfile();
