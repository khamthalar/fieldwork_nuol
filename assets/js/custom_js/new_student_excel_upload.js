function open_file(){
    document.getElementById('upload').addEventListener('change', handleFileSelect, false);
    $('#upload').click();
}
function handleFileSelect(evt) {
    var files = evt.target.files;
    var xl2json = new ExcelToJSON();
    xl2json.parseExcel(files[0]);
}
var ExcelToJSON = function() {
    this.parseExcel = function(file) {
        document.getElementById('path').innerHTML = file.name;
        var reader = new FileReader();
        reader.onload = function(e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {type: 'binary'}); 
            var worksheet = workbook.Sheets[workbook.SheetNames[0]];
            const student_data = XLSX.utils.sheet_to_json(worksheet,{
                header:1,
                defval:""
            });
            var tb_body = document.getElementById('tb_body');
            tb_body.innerHTML = ``;
            try {
                // console.log(student_data[2]);
                if(student_data[2][0]=="ລ/ດ\nNo"
                && student_data[2][1]=="ລະຫັດນັກສຶກສາ\nStudent ID"
                && student_data[2][2]==""
                && student_data[2][3]=="ເພດ"
                && student_data[2][4]=="ຊື່ ແລະ ນາມສະກຸນ"
                && student_data[2][5]==""
                && student_data[2][6]=="REMARK"
                ){
                    var row_str = ``;
                    st_data = [];
                    for(let i=3;i < student_data.length;i++){
                        if(student_data[i][1]!=""&&student_data[i][2]!=""){
                            row_str +=`
                            <tr>
                                <td class='notosans f12 center'>`+student_data[i][0]+`</td>
                                <td class='notosans f12'>`+student_data[i][1]+`</td>
                                <td class='notosans f12'>`+student_data[i][2]+`</td>
                                <td class='notosans f12 center'>`+student_data[i][3]+`</td>
                                <td class='notosans f12'>`+student_data[i][4]+`</td>
                                <td class='notosans f12'>`+student_data[i][5]+`</td>
                                <td class='notosans f12'>`+student_data[i][6]+`</td>
                            </tr>`;
                            var item = {
                                            student_code:student_data[i][1]+"-"+student_data[i][2],
                                            gender:student_data[i][3],
                                            name_la:student_data[i][4],
                                            surname_la:student_data[i][5],
                                            remake:student_data[i][6]
                                        };
                            st_data.push(item);
                        }
                    }
                    // console.log(st_data);
                    tb_body.innerHTML = row_str;
                    if(st_data.length!=0){
                        btn_upload.hidden = false;
                    }else{
                        btn_upload.hidden = true;
                    }
                }else{
                    Swal.fire({icon:'warning',html:`<span class="notosans">ຂໍ້ມູນບໍ່ຖືກຕ້ອງ</span>`});
                    st_data = [];
                    btn_upload.hidden = true;
                }
            } catch (error) {
                // Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=classroom&sub_page=class_member".$class_id_param.$class_des_param."'}});
                Swal.fire({icon:'error',html:`<span class="notosans">`+error.message+`</span>`});
                st_data = [];
                btn_upload.hidden = true;
            }
        };

        reader.onerror = function(ex) {
            // console.log(ex);
            Swal.fire({icon:'error',html:`<span class="notosans">ເກີດຂໍ້ຜິດພາດລະຫວ່າງການເປີດຟາຍ</span>`});
            st_data = [];
            btn_upload.hidden = true;
        };
        reader.readAsBinaryString(file);
    };
};