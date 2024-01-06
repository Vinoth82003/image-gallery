// // Load xlsx library from CDN
// var script = document.createElement('script');
// script.type = 'text/javascript';
// script.src = 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js';
// document.head.appendChild(script);

// let all_rows = document.querySelectorAll("a.table-row");
// let allBrands = [];

// all_rows.forEach(row => {
//     let sno = row.querySelector(".rank.first.table-cell.rank").innerHTML;
//     let companyName = row.querySelector(".organizationName.second.table-cell.name").innerHTML;
//     let countryName = row.querySelector(".country.table-cell.country").innerHTML;

//     // Create an object for each row
//     let brand = {
//         sno: sno,
//         companyName: companyName,
//         countryName: countryName
//     };

//     // Push the object to the array
//     allBrands.push(brand);
// });

// console.table(allBrands);
// // Function to convert the data to Excel and download
// function downloadExcel(data, filename) {
//     const ws = XLSX.utils.json_to_sheet(data);
//     const wb = XLSX.utils.book_new();
//     XLSX.utils.book_append_sheet(wb, ws, "Sheet 1");
//     XLSX.writeFile(wb, filename + ".xlsx");
// }

// // Call the function to download Excel
// downloadExcel(allBrands, "brands_data");
