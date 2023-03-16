function DownloadFile(fileName) {
    var url = "assets/files/" + fileName;
    var a = document.createElement("a");
    a.setAttribute("download", fileName);
    a.setAttribute("href", url);
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
};
function goto_excel_upload(){
    window.location.href='template?page=student&sub_page=new_student_excel_upload&course_id='+course_id;
}
function course_selected(value){
    window.location.href = 'template?page=student&course_id2='+value;
}
function delete_student(student_code){
    Swal.fire({
        icon: 'question',
        html:'<div class="notosans">ທ່ານຕ້ອງການລຶບຂໍ້ມູນນັກສຶກສາແມ່ນບໍ່</div>',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<div class="notosans">ຕົກລົງ</div>',
        cancelButtonText:'<div class="notosans">ຍົກເລີກ</div>'
    }).then((result)=>{
        if (result.isConfirmed) {
            var param={
                student_code:student_code,
                username:_username
            }
            var http = new XMLHttpRequest();
            http.open( "POST", 'controller/student_controller.php', true );
            http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
            http.onreadystatechange = async function () {
                if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
                    var status = JSON.parse( this.responseText );
                    if(status.success){
                        await Swal.fire(
                            {icon:'success',
                            html:"Delete Success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.location.reload();
                    }else{
                        await Swal.fire({icon:'error',
                        html:"Internal server error",
                        showConfirmButton: false,
                        timer: 1500});
                    }
                }
            }
            var _param = encode( JSON.stringify( param ) );
            http.send( "delete_student=" + _param );
        }
    })
}

function decode( text ) {
    return text
        .replaceAll( "#amp;",'&' )
        .replaceAll( "#quot;",'"' )
        .replaceAll( "#plus;",'+' )
        .replaceAll( "#039;","'" )
  }
  function encode( text ) {
    return text
        .replace( /&/g, "#amp;" )
        .replace( /"/g, "#quot;" )
        .replace( /\+/g, "#plus;" )
        .replace( /'/g, "#039;" );
  }