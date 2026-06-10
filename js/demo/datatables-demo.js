$(document).ready(function () {
  $('#dataTable').DataTable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/fr-FR.json"
    },
    pageLength: 5,
    lengthMenu: [
      [5, 10, 25, 50, -1],
      [5, 10, 25, 50, "Tous"]
    ]
  });
});