// student data excel update
function open_file() {
    document.getElementById( 'upload' ).addEventListener( 'change', handleFileSelect, false );
    $( '#upload' ).click();
}
function handleFileSelect( evt ) {
    var files = evt.target.files;
    var xl2json = new ExcelToJSON();
    xl2json.parseExcel( files[ 0 ] );
}
var ExcelToJSON = function () {
    this.parseExcel = function ( file ) {
        document.getElementById( 'path' ).innerHTML = file.name;
        var reader = new FileReader();
        reader.onload = function ( e ) {
            var data = e.target.result;
            var workbook = XLSX.read( data, { type: 'binary' } );
            var worksheet = workbook.Sheets[ workbook.SheetNames[ 0 ] ];
            const student_data = XLSX.utils.sheet_to_json( worksheet, {
                header: 1,
                defval: ""
            } );
            var tb_body = document.getElementById( 'tb_body' );
            tb_body.innerHTML = ``;
            try {
                console.log(student_data[1]);
                if((student_data[1][0]).toLowerCase().replace("\r","")==("ລ/ດ\nNo").toLowerCase()
                && (student_data[1][1]).toLowerCase().replace("\r","")==("ລະຫັດນັກສຶກສາ\nStudent ID").toLowerCase()
                && (student_data[1][2]).toLowerCase()==("ເພດ").toLowerCase()
                && (student_data[1][3]).toLowerCase()==("ຊື່ ແລະ ນາມສະກຸນ").toLowerCase()
                && (student_data[1][4]).toLowerCase()==("").toLowerCase()
                && (student_data[1][5]).toLowerCase()==("Name and Surname").toLowerCase()
                && (student_data[1][6]).toLowerCase()==("").toLowerCase()
                && (student_data[1][7]).toLowerCase()==("ວັນເດືອນປີເກີດ").toLowerCase()
                && (student_data[1][8]).toLowerCase()==("ສະຖານທີ່ເກີດ (ແຂວງ)").toLowerCase()
                && (student_data[1][9]).toLowerCase()==("address of birth (province)").toLowerCase()
                && (student_data[1][10]).toLowerCase()==("REMARK").toLowerCase()){
                    var row_str = ``;
                    st_data = [];
                    for ( let i = 2; i < student_data.length; i++ ) {
                        if ( student_data[ i ][ 1 ] != "" && student_data[ i ][ 2 ] != "" ) {
                            row_str += `
                            <tr>
                                <td class='notosans f12 center'>`+ student_data[ i ][ 0 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 1 ] + `</td>
                                <td class='notosans f12 center'>`+ student_data[ i ][ 2 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 3 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 4 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 5 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 6 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 7 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 8 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 9 ] + `</td>
                                <td class='notosans f12' colspan='2'>`+ student_data[ i ][ 10 ] + `</td>
                            </tr>`;
                            var item = {
                                student_code: student_data[ i ][ 1 ] + student_data[ i ][ 2 ],
                                gender: student_data[ i ][ 3 ],
                                name_la: student_data[ i ][ 4 ],
                                surname_la: student_data[ i ][ 5 ],
                                remark: student_data[ i ][ 6 ]
                            };
                            st_data.push( item );
                        }
                    }
                    tb_body.innerHTML = row_str;
                    if ( st_data.length != 0 ) {
                        btn_upload.hidden = false;
                    } else {
                        btn_upload.hidden = true;
                    }
                } else {
                    Swal.fire( { icon: 'warning', html: `<span class="notosans">ຂໍ້ມູນບໍ່ຖືກຕ້ອງ</span>` } );
                    st_data = [];
                    btn_upload.hidden = true;
                }
            } catch ( error ) {
                // Swal.fire({icon:'success',html:'<span class=notosans>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=classroom&sub_page=class_member".$class_id_param.$class_des_param."'}});
                Swal.fire( { icon: 'error', html: `<span class="notosans">` + error.message + `</span>` } );
                st_data = [];
                btn_upload.hidden = true;
            }
        };

        reader.onerror = function ( ex ) {
            Swal.fire( { icon: 'error', html: `<span class="notosans">ເກີດຂໍ້ຜິດພາດລະຫວ່າງການເປີດຟາຍ</span>` } );
            st_data = [];
            btn_upload.hidden = true;
        };
        reader.readAsBinaryString( file );
    };
}