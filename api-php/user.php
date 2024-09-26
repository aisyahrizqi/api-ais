<?php

require_once 'koneksi.php';

if (function_exists($_GET['function'])) {
    $_GET['function']();
}

// function untuk menampilkan data

function tampilData()
{
    global $koneksi;

    $sql = mysqli_query($koneksi, "SELECT * FROM users");
    while ($data = mysqli_fetch_object($sql)) {
        $user[] = $data;
    }

    $respon = array(
        'status' => 200,
        'pesan' => 'Berhasil Menampilkan Data',
        'users' => $user
    );

    header('Content-type: application/json');
    print json_encode($respon);
}
//    Menambah Data
function tambahData()
{
    global $koneksi;

    $isi = array(
        'nama' => '',
        'alamat' => '',
        'no_telp' => ''
    );

    $cek = count(array_intersect_key($_POST, $isi));

    if ($cek == count($isi)) {
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];

        $hasil = mysqli_query($koneksi, "INSERT into users values('', '$nama', '$alamat', '$no_telp')");

        if ($hasil) {
            return pesan(1, "Berhasil menambahkan data $nama");
        } else {
            return pesan(0, "Gagal menambahkan data $nama");
        }
    } else {
        return pesan(0, "Gagal menambahkan data, parameter salah");
    }
}


function pesan($status, $pesan)
{
    $respon = array(
        'status' => $status,
        'pesan' => $pesan
    );

    header('Content-type: application/json');
    print json_encode($respon);
}


    // edit data
    function editData()
    {
        global $koneksi;

        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
        }

        $isi = array(
            'nama' => '',
            'alamat' => '',
            'no_telp' => ''
        );

        $cek = count(array_intersect_key($_POST, $isi));

        if ($cek == count($isi)) {
            $nama = $_POST['nama'];
            $alamat = $_POST['alamat'];
            $no_telp = $_POST['no_telp'];

            $sql = mysqli_query($koneksi, "UPDATE users set id='$id', nama='$nama', alamat='$alamat', no_telp='$no_telp' WHERE id='$id'");

            if ($sql) {
                return pesan(status: 1, pesan: "Berhasil mengedit data $nama");
            } else {
                return pesan(status: 0, pesan: "Gagal mengedit data $nama");
            }
        } else {
            return pesan(status: 0, pesan: "Gagal mengedit data, parameter salah");
        }
    }

    // menghapus data

function hapusData(){
        global $koneksi;

        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
        }
        $sql = mysqli_query($koneksi, "DELETE from users WHERE id='$id'");

        if($sql){
            return pesan(status: 1, pesan: "Berhasil hapus data");
        }else{
            return pesan(status: 0, pesan: "Gagal hapus data");
        }
}

// Menampilkan detail data

function detailData(){
    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $sql = mysqli_query($koneksi, "SELECT * from users where id='$id'");
    $data = mysqli_fetch_object($sql);

    $respon = array(
        'status' => 200,
        'pesan' => 'Berhasil menampilkan data',
        'user' => $data
    );

    header('Content-type: application/json');
    print json_encode($respon);
}

