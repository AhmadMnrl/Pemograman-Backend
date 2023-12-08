/**
 * TODO 3:
 * - import fruits dari data/fruits.js
 * - refactor variabel ke ES6 variable
 */
// import fruits dari data/fruits.js
let fruits = require("../Models/fruits.js");

/**
 * TODO 4:
 * - Buat method index.
 * - Refactor function ke ES6 Arrow Function
 * - Tampilkan data fruits.
 *
 * @hint - Gunakan looping for of
 */
// Buat method index
const index = () => {
  // Refactor function ke ES6 Arrow Function
  // Tampilkan data fruits
  for (const fruit of fruits) {
    console.log(fruit);
  }
};

/**
 * TODO 5:
 * - Buat method store.
 * - Refactor function ke ES6 Arrow Function
 * - Menambahkan data baru ke array fruits.
 *
 * @param {string} name - Nama buah.
 *
 * @hint - Gunakan method push
 */
// Buat method store
const store = (name) => {
  // Refactor function ke ES6 Arrow Function
  // Menambahkan data baru ke array fruits
  fruits.push(name);
  index();
};

/**
 * TODO 6:
 * - Buat method update.
 * - Refactor function ke ES6 Arrow Function
 * - Memperbarui data fruits.
 *
 * @param {number} position - Posisi atau index yang ingin diupdate.
 * @param {string} name - Nama buah yang baru.
 */
// Buat method update
const update = (position, name) => {
  // Refactor function ke ES6 Arrow Function
  // Memperbarui data fruits
  fruits[position] = name;
  index();
};

/**
 * TODO 7:
 * - Buat method destroy.
 * - Refactor function ke ES6 Arrow Function
 * - Menghapus data fruits.
 *
 * @param {number} position - Posisi atau index yang ingin dihapus
 *
 * @hint - Gunakan method splice
 */
// Buat method destroy
const destroy = (position) => {
  // Refactor function ke ES6 Arrow Function
  // Menghapus data fruits
  fruits.splice(position, 1);
  index();
};

/**
 * TODO 8: export method index, store, update, dan destroy
 */
module.exports = { index, store, update, destroy };