// const MY_URL = "https://if20.skom.id/back/public";
const MY_URL = "http://127.0.0.1:8000"


$("[name=provinsi]").on("change", (e) => {
    let selectedProvinsi = e.target.value;
    let kabupaten = $("[name=kabupaten]");
    getKabupaten(selectedProvinsi, kabupaten);
    // $("[name=kabupaten_aktivitas]").toggle("hidden")
});
const getKabupaten = (idProvinsi, el) => {
    $.get(`${MY_URL}/getKabupaten/${idProvinsi}`, (data, status) => {
        let dataKabupaten = [`<option value="#" disabled selected>Kabupaten</option>`];
        data.data.forEach((val, i) => {
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

const getKecamatan = (idKabupaten, el) => {
    $.get(`${MY_URL}/getKecamatan/${idKabupaten}`, (data, status) => {
        let dataKabupaten = [`<option value="#" disabled selected>Kecamatan</option>`];
        data.data.forEach((val, i) => {
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



const getKelurahan = (idKecamatan, el) => {
    $.get(`${MY_URL}/getKelurahan/${idKecamatan}`, (data, status) => {
        let dataKelurahan = [`<option value="#" disabled selected>Kelurahan</option>`];
        data.data.forEach((val, i) => {
            dataKelurahan.push(`<option value="${val.id}">${val.nama}</option>`);
        });
        el.html(dataKelurahan.join(""));
    })
}


$('body').on('click', '#hapus_customer', function (e) {
    e.preventDefault();

    var link = $(this).attr('href');

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Untuk Menghapus Data Customer Ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = link;
        } else if (result.dismiss) {
            Swal.fire(
                'Canceled!',
                'Data tidak jadi dihapus'
            )
        }
    })
})

$('body').on('click', '#hapus_hewan', function (e) {
    e.preventDefault();

    var link = $(this).attr('href');

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Untuk Menghapus Data Hewan Ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = link;
        } else if (result.dismiss) {
            Swal.fire(
                'Canceled!',
                'Data tidak jadi dihapus'
            )
        }
    })
})

var $modal = $('#modal_image');
var gambarYgDikirim = $('#gambar_hewan_send');
var image = document.getElementById('image_modal');
var cropper;

// pada saat add data baru
$("body").on("change", "#gambar_hewan", function (e) {
    var files = e.target.files;
    var done = function (url) {
        image.src = url;
        $modal.modal('show');
    };
    var reader;
    var file;
    var url;
    if (files && files.length > 0) {
        file = files[0];
        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
});

$modal.on("shown.bs.modal", function () {
    cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 3,
        preview: '.preview'
    });
}).on('hidden.bs.modal', function () {
    cropper.destroy();
    cropper = null;
    image.src = '';
    $('#upload_profile').val('');
});
$("#btn_crop_image").click(function () {
    canvas = cropper.getCroppedCanvas({
        width: 160,
        height: 160,
    });
    canvas.toBlob(function (blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function () {
            var base64data = reader.result;
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "saveImageHewan",
                data: {
                    '_token': $('meta[name="_token"]').attr('content'),
                    'image': base64data
                },
                success: function (data) {
                    // console.log(data);
                    gambarYgDikirim.val(data.data);
                    $modal.modal('hide');
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Gambar Berhasil Di Crop',
                    })
                },
                error: function (error) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal
                                .stopTimer)
                            toast.addEventListener('mouseleave', Swal
                                .resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: `${error.message}`,
                    })
                }
            });
        }
    });
})

//pada saat update data




var options = {
    series: [
        {
            name: "Desktop",
            data: randData()//data: [4, 61, 45, 26, 79, 13, 55, 22, 78],
        }
    ],
    chart: {
        height: 400,
        type: "line",
        zoom: {
            enabled: false
        },
        toolbar: {
            show: false
        }
    },
    markers: {
        show: true,
        size: 6
    },
    dataLabels: {
        enabled: false
    },
    legend: {
        show: true,
        showForSingleSeries: true,
        position: "top",
        horizontalAlign: "right"
    },
    stroke: {
        curve: "smooth",
        linecap: "round"
    },
    grid: {
        row: {
            colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
            opacity: 0.5
        }
    },
    xaxis: {
        categories: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep"
        ]
    }
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();


function appendChartSeries() {
    var data = randData();
    // Append new data to existing Chart
    chart.appendSeries({
        name: "New Series",
        data: data,
        //data: [4, 61, 45, 26, 79, 13, 55, 22, 78],
        animate: true
    });
}

function updateChartSeries() {
    var data = randData();
    // Replace data to existing Chart
    chart.updateSeries([
        {
            name: "Pizza",
            data: data
        }
    ]);
}

function updateChartOptions() {
    chart.updateOptions({
        chart: {
            type: "bar",
            animate: true
        },
        labels: '',
        stroke: {
            width: 0
        }
    });
}
function updateChartOptions2() {
    chart.updateOptions({
        chart: {
            type: "line",
            animate: true
        },
        labels: '',
        stroke: {
            width: 6
        }
    });
}
function updateChartOptions3() {
    chart.updateOptions({
        chart: {
            type: "donut",
            animate: true
        },
        series: [44, 55, 13],
        labels: ['Apple', 'Orange', 'Watermelon']
    });
}

$(".btn-append").on("click", function () {
    appendChartSeries();
});
$(".btn-update").on("click", function () {
    updateChartSeries();
});

$(".btn-options").on("click", function () {
    updateChartOptions();
});
$(".btn-options2").on("click", function () {
    updateChartOptions2();
});
$(".btn-options3").on("click", function () {
    updateChartOptions3();
});

function randData() {
    var arr = [];
    for (var i = 0; i < 9; i++) {
        arr.push(Math.floor(Math.random() * 200) + 1);
    }

    var str = [];
    for (var i = 0; i < 9; i++) {
        str[i] = arr[i];
    }
    return str;
}
