/**
 * Fungsi untuk menampilkan hasil download
 * @param {string} result - Nama file yang didownload
 */
// Refactor function ke ES6 Arrow Function
const showDownload = (result) => {
  console.log("Download selesai");
  // Refactor string ke ES6 Template Literals
  console.log(`Hasil Download: ${result}`);
};

/**
 * Fungsi untuk download file
 * @param {function} callback - Function callback show
 */
// Refactor function ke ES6 Arrow Function
const download = (callShowDownload) => {
  setTimeout(() => {
    const result = "windows-10.exe";
    callShowDownload(result);
  }, 3000);
};

// Refactor callback ke Promise atau Async Await
// Gunakan Promise
const downloadPromise = () => {
  return new Promise((resolve, reject) => {
    download(resolve);
  });
};

// Gunakan Async Await
const main = async () => {
  const result = await downloadPromise();
  showDownload(result);
};

main();