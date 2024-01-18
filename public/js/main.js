$(document).ready(function () {
  // global variable
  let data1= ''

  $("#content").on('change',function () {
    console.log("Button Clicked");
    // check text area not empty
    console.log($("#content").val().length)
    $("#output1").html("");
    $("#input-message").html("");
    $('#words-for-quote').html(``)

    
    if($("#content").val().length == 0){
      $("#input-message").html("This field is required!");
      $('#download-button').hide()
      $('.accordion-item').hide()
      return
    }
    
    // $("#loader").show()

    // get text_data form text_area
    var data = $("#content").val().split(" ");

    // remove white spaces
    var source_data_list1 = [];
    data.forEach((nn) => {
      if (nn != "") source_data_list1.push(nn);
    });

    // filter data
    let source_data_list = []


    source_data_list1.forEach(data => {
      // // filter if string is email or number only 
      if(!validateEmail(data) && /[a-zA-Z]/.test(data)){
        source_data_list.push(data)
      }
    })

    // // check string is email or not
    function validateEmail (emailAdress)
      {
        let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (emailAdress.match(regexEmail)) {
          return true; 
        } else {
          return false; 
        }
      }
      console.log(source_data_list)

      if(source_data_list.length > 500){
        alert("Data is too long")
        $("#output1").html("");
        $("#input-message").html("");
        $('#words-for-quote').html(``)
        $('#download-button').hide()
        $('.accordion-item').hide()
        $("#loader").hide()
        return 
      }

    var source_data = source_data_list.join(" ^^ ");

    const url = "https://gistlangserver.in/api/Leveraging/GetLeverage";
    // const url = "https://lang.tdil-dc.gov.in/api/Leveraging/GetLeverage";

    var t_lang = 'mar';//$(".language-combo").val();
    console.log(t_lang);

    var data = {
      ClientID: "Demo Test Page",
      sText: source_data,
      sLocale: "eng",
      tLocale: t_lang,
      mapID: "",
      delimiter: "^^",
      isNameTrans: "false",
      isTrans: "false",
      isOnlyTrans: "false",
      WordTrans: "false",
      isJSON: "false",
      MTName: "",
    };

    $.ajax({
      url: url,
      type: "POST",
      dataType: "json",
      contentType: "application/json",
      data: JSON.stringify(data),
      success: function (response) {
        var res = response.response;
        var target_data = res.slice(0, res.lastIndexOf("(^)"));

        // var target_data_list = target_data.replaceAll("0^^", "&&").replaceAll("1^^", "&&").split("&&")
        var target_data_list = target_data.split("^^");



        // remove 0 and 1 from end
        // var targetDataList = target_data_list.map((d) => d.slice(0, -1));
        var final_str = "";
        var all_data = [];
        source_data_list.forEach((item, i) => {
          if(final_str == ""){
            final_str = target_data_list[i].slice(0, -1).trim();
          } else {
            final_str = final_str+' '+target_data_list[i].slice(0, -1).trim();
          }
          all_data.push({
            source_text: item,
            target_text: target_data_list[i].slice(0, -1),
            translated: target_data_list[i].slice(-1) == 0,
          });
        });
        $('#content').val(final_str);
        $('#translated_text').val(final_str);
        console.log(final_str);
        // var new_data = "";
        // all_data.forEach((a) => {
        //   new_data = new_data + a.source_text + "=" + a.target_text + "\n";
        // });

        // console.log(new_data);

        // // assign txt data to global variable
        // data1 = new_data

        // // create a txt file with a=b format
        // // var blob = new Blob([new_data],
        // //         { type: "text/plain;charset=utf-8" });
        // // saveAs(blob, 'static.txt')

        // // filter converted and non converted data
        // var converted_data = [];
        // var non_converted_data = [];

        // target_data_list.forEach((d) => {
        //   if (d.charAt(d.length - 1) == 0)
        //     converted_data.push(d.slice(0, -1).trim());
        //   else non_converted_data.push(d.slice(0, -1).trim());
        // });

        // console.log(converted_data);
        // console.log(non_converted_data);

        // // remove repeated string
        // nonConvertedDataWithoutRepeat = [...new Set(non_converted_data)];
        // console.log(nonConvertedDataWithoutRepeat)

        // // totaol count for estimation 
        // // all non converted row having 

        // let nonConvertedString = nonConvertedDataWithoutRepeat.join(" ")
        // console.log(nonConvertedString)

        // let nonConvertedWords = nonConvertedString.split(/\s+/)
        // console.log("Non ", nonConvertedWords)

        // nonConvertedWords.forEach(word => (
        //   $('#words-for-translation').append(word + ",     ")
        // ))

        // split with white space
        // let totalWordCount
        // if(nonConvertedString == ''){
        //   totalWordCount = 0
        // }else{
          
          
        //   // total count of 
        //   totalWordCount = nonConvertedWords.length
        // }
        

        // filter translated data and non translated data
        // var table_data = all_data.map(
        //   (data) =>
        //     `<tr><td>${data.source_text}</td><td>${data.target_text}</td></tr>`
        // );

        // console.log(table_data);

        // add show download button
        // $('#download-button').show()
        // $('.accordion-item').show()
        // $("#loader").hide()

        // display total words 
        // $('#words-for-quote').html(`Total Words For Translation :<span class="word-count"> ${totalWordCount}</span>`)

        // $("#output1").html(`<div><table style="border: 2px solid black;"><tr><th style="border: 2px solid black; width: 200px; padding: 2px 10px;">Source Text</th><th style="border: 2px solid black; width: 200px; padding: 2px 10px;">Translated Text</th></tr>${table_data}</table></div>`)
        // $("#output1").html(`${table_data}`);
      },
      error: function (error) {
        console.log("Error : ", error);
        if (error.status != "200") {
          $("#output1").html(
            '<h5 style="color: red;">Something went wrong</h5>'
          );
        }
      },
    });
  });


  // 
  // $("#download").click(function () {
  //   console.log("in in", data1);

  //   // create a txt file in a=b format
  //   var blob = new Blob([data1], { type: "text/plain;charset=utf-8" });
  //   saveAs(blob, "data.txt");
  // });
});


// $("#show-empanelled").click(function () {
//   console.log("In show empanelled agencies");

//   if(document.getElementById('show-empanelled1').text == "Hide Empanelled Agencies"){
//     document.getElementById('show-empanelled1').text = "Show Empanelled Agencies"
//   }else{
//     document.getElementById('show-empanelled1').text = "Hide Empanelled Agencies"
//   }
  

//   $('#empanelled-agencies').toggle()
// })