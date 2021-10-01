function logout() {
  $.ajax({
    type: "GET",
    url: baseUrl + "/api/me/logout",
    success: function (response) {
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
  $.get(baseUrl + "/api/me", (resp) => {
    let user = resp.data
    !user.surname
      ? $(".profile-name").text(user.name)
      : $(".profile-name").text(`${user.name} ${user.surname}`);
  });
}

getProfile();
