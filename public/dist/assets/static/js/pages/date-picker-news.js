flatpickr(".flatpickr-no-config", {
    enableTime: false,
    dateFormat: "Y-m-d",
});
// flatpickr(".flatpickr-year", {
//     plugins: [
//         new monthSelectPlugin({
//             shorthand: true, // Display as short month (optional)
//             dateFormat: "Y", // Show only year in the input field
//             altFormat: "Y", // Show only year in the alternate input
//             theme: "light", // Use light theme (optional)
//         }),
//     ],
//     disableMobile: true, // Disable mobile native picker
// });
flatpickr(".flatpickr-month", {
    plugins: [
        new monthSelectPlugin({
            shorthand: true, // Display as short month (optional)
            dateFormat: "Y", // Show only year in the input field
            altFormat: "Y", // Show only year in the alternate input
            theme: "light", // Use light theme (optional)
        }),
    ],
    disableMobile: true, // Disable mobile native picker
});

document.addEventListener("DOMContentLoaded", function () {
    flatpickr(".flatpickr-year", {
        dateFormat: "Y", // Only show the year in the input
        altInput: true, // Show formatted date in the input
        altFormat: "Y", // Alternative format for display
        minDate: "1900-01-01", // Optional: Minimum selectable year
        maxDate: new Date().getFullYear() + "-12-31", // Optional: Maximum selectable year
        enableTime: false, // Disable time selection
        // Plugins configuration if needed
        plugins: [
            new monthSelectPlugin({
                shorthand: true,
                dateFormat: "Y",
                altFormat: "Y",
            }),
        ],
    });
});
