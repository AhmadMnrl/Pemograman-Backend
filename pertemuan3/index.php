<?php
class Animal
{
    private $animals;
    public function __construct($data)
    {
        $this->animals = $data;
    }
    public function index()
    {
        echo "List of Animals:<br>";
        foreach ($this->animals as $key => $animal) {
            echo "- " . $animal . "<br>";
        }
    }
    public function store($data)
    {
        array_push($this->animals, $data);
        echo "$data has been added to the list.<br>";
    }
    public function update($index, $data)
    {
        if (isset($this->animals[$index])) {
            $this->animals[$index] = $data;
            echo "Animal at index $index has been updated to $data.<br>";
        } else {
            echo "Animal not found. Update failed.<br>";
        }
    }
    public function destroy($index)
    {
        if (isset($this->animals[$index])) {
            unset($this->animals[$index]);
            $this->animals = array_values($this->animals);
            echo "Animal at index $index has been removed from the list.<br>";
        } else {
            echo "Animal not found. Deletion failed.<br>";
        }
    }
}
$animal = new Animal(['Ayam', 'Ikan']);

echo "Index - Menampilkan seluruh hewan <br>";
$animal->index();
echo "<br>";

echo "Store - Menambahkan hewan baru <br>";
$animal->store('Burung');
$animal->index();
echo "<br>";

echo "Update - Mengupdate hewan <br>";
$animal->update(0, 'Kucing Anggora');
$animal->index();
echo "<br>";

echo "Destroy - Menghapus hewan <br>";
$animal->destroy(1);
$animal->index();
echo "<br>";
