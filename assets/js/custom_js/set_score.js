var ans_data;
Swal.fire( {
    html: '<h2 class="phetsarath">ກະລຸນາລໍຖ້າ !</h2><h4 class="phetsarath">ກໍາລັງໂຫຼດຂໍ້ມູນ</h4>',
    timer: 300,
    allowOutsideClick: false,
    didOpen: () => {
        Swal.showLoading()
    }
}).then( () => {
    load_ans_data();
    load_data();
});
Swal.stopTimer();
var http = new XMLHttpRequest();
http.open( "POST", 'controller/quiz_overview_controller.php', true );
http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
http.onreadystatechange = function () {
    if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
        var res = JSON.parse(this.responseText);
        var data = JSON.stringify(res);
        // console.log(data);
        var data_encode = CryptoJS.AES.encrypt( data, "ans" ).toString();
        sessionStorage.setItem( "ans_data", data_encode );
        Swal.resumeTimer();
    }
}
var _param = encode( JSON.stringify( param ) );
http.send( "load_ans=" + _param );
function load_ans_data(){
    var data_encode = sessionStorage.getItem("ans_data");
    ans_data = JSON.parse(CryptoJS.AES.decrypt(data_encode,"ans").toString( CryptoJS.enc.Utf8 ));
    // console.log(ans_data);
}
function load_data(){
    var questions = ans_data;
    var question = document.getElementById("questions");
    question.innerHTML = ``;
    questions.forEach((quest,index) => {
        var quest_content = document.createElement("div");
        quest_content.className ="quest_content";
        quest_content.innerHTML = ``;
        var title = document
        var title = document.createElement("div");
        title.className = "title";
        var question_title = document.createElement("div");
        question_title.className = "quest-title";
        var quest_number = document.createElement("span");
        quest_number.className = "quest-number";
        quest_number.innerHTML = (index+1)+". ";
        var quest_des = document.createElement("span");
        quest_des.className = "quest-des phetsarath";
        quest_des.innerHTML = decodeHTMLEntities(quest.question_title);
        question_title.appendChild(quest_number);
        question_title.appendChild(quest_des);
        title.appendChild(question_title);
        quest_content.appendChild(title);
        if(quest.question_des !="" && quest.show_ques_content==0){
            var quest_body = document.createElement("div");
            quest_body.className = "quest-body phetsarath";
            quest_body.innerHTML = decodeHTMLEntities(quest.question_des);
            quest_content.appendChild(quest_body);
        }
        var ans_box = document.createElement( "div" );
        ans_box.className = "ans-box";
        ans_box.innerHTML = decodeHTMLEntities(quest.answer);
        quest_content.appendChild(ans_box);
        var score_box = document.createElement("div");
        score_box.className = "score-box phetsarath";
        score_box.innerHTML = `ຄະແນນ: <input type="number" class="center txt-score" min="0" max="`+quest.full_point+`" value="`+quest.point+`">`;
        // quest_content.appendChild(score_box);
        question.appendChild(quest_content);
        question.appendChild(score_box);
    });
    var act_btn = document.createElement("div");
    act_btn.className = "action-btn center";
    act_btn.innerHTML = `
    <button onclick="window.location.href='template?page=quiz_overview'" type="button" class="btn btn-danger phetsarath">ຍົກເລີກ</button>
    <button type="button" class="btn btn-success phetsarath">ບັນທຶກ</button>`;
    question.appendChild(act_btn);

    // question.appendChild(quest_content);
}
function decodeHTMLEntities( text ) {
    var entities = [
        [ 'amp', '&' ],
        [ 'apos', '\'' ],
        [ '#x27', '\'' ],
        [ '#x2F', '/' ],
        [ '#39', '\'' ],
        [ '#47', '/' ],
        [ 'lt', '<' ],
        [ 'gt', '>' ],
        [ 'nbsp', ' ' ],
        [ 'quot', '"' ]
    ];

    for ( var i = 0, max = entities.length; i < max; ++i )
        text = text.replace( new RegExp( '&' + entities[ i ][ 0 ] + ';', 'g' ), entities[ i ][ 1 ] );
    return text;
}
function encode( text ) {
    return text
        .replace( /&/g, "#amp;" )
        .replace( /"/g, "#quot;" )
        .replace( /\+/g, "#plus;" )
        .replace( /'/g, "#039;" );
}