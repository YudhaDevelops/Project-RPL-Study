// const MY_URL = "https://if20.skom.id/back/public";
const MY_URL = "http://127.0.0.1:8000"

$("[name=provinsi]").on("change", (e) => {
    let selectedProvinsi = e.target.value;
    let kabupaten = $("[name=kabupaten]");
    getKabupaten(selectedProvinsi, kabupaten);
    // $("[name=kabupaten_aktivitas]").toggle("hidden")
});
const getKabupaten = (idProvinsi,el)=>{
    $.get(`${MY_URL}/getKabupaten/${idProvinsi}`,(data,status)=>{
        let dataKabupaten = [`<option value="#" disabled selected>Kabupaten</option>`];
        data.data.forEach((val,i) => {
            dataKabupaten.push(`<option value="${val.id}">${val.nama}</option>`);
        });
        el.html(dataKabupaten.join(""));
    })
}

$("[name=kabupaten]").on("change", (e) => {
    let selectedKabupaten = e.target.value;
    let kecamatan = $("[name=kecamatan]");
    getKecamatan(selectedKabupaten, kecamatan);
    // $("[name=kabupaten_aktivitas]").toggle("hidden")
});

const getKecamatan = (idKabupaten,el)=>{
    $.get(`${MY_URL}/getKecamatan/${idKabupaten}`,(data,status)=>{
        let dataKabupaten = [`<option value="#" disabled selected>Kecamatan</option>`];
        data.data.forEach((val,i) => {
            dataKabupaten.push(`<option value="${val.id}">${val.nama}</option>`);
        });
        el.html(dataKabupaten.join(""));
    })
}

$("[name=kecamatan]").on("change", (e) => {
    let selectedKecamatan = e.target.value;
    let kelurahan = $("[name=kelurahan]");
    getKelurahan(selectedKecamatan, kelurahan);
    // $("[name=kabupaten_aktivitas]").toggle("hidden")
});



const getKelurahan = (idKecamatan,el)=>{
    $.get(`${MY_URL}/getKelurahan/${idKecamatan}`,(data,status)=>{
        let dataKelurahan = [`<option value="#" disabled selected>Kelurahan</option>`];
        data.data.forEach((val,i) => {
            dataKelurahan.push(`<option value="${val.id}">${val.nama}</option>`);
        });
        el.html(dataKelurahan.join(""));
    })
}