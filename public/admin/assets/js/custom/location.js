
let fetchStatesByCountry = (elem, name, url)=>{
    $(`select[name=${name}]`).css({display: 'none'});
  
    $(`select[name=${name}]`).prev().html(`<i class="la la-spinner la-spin"></i> Loading...`);
    
    $.ajax({
        url: `${url}/resource-provider/states?id=${elem.value}`,
        type: 'GET',
        success: res => {
            let options = '<option value="">Select State...</option>';
  
            res.data.forEach(obj => {
                options += `<option value="${obj.id}">${obj.name}</option>`;
            });
  
            $(`select[name=${name}]`).html(options);
            $(`select[name=${name}]`).prev().html("");
            $(`select[name=${name}]`).css({display: 'block'});
        },
        error: err => {
            $(`select[name=${name}]`).prev().html(`<b style="color:red">* something went wrong!</b>`);
            console.error(err);
        }
    });
  }
  
  let fetchCitiesByState = (elem, name, url)=>{
    $(`select[name=${name}]`).css({display: 'none'});
  
    $(`select[name=${name}]`).prev().html(`<i class="la la-spinner la-spin"></i> Loading...`);
    
    $.ajax({
        url: `${url}/resource-provider/cities?id=${elem.value}`,
        type: 'GET',
        success: res => {
            let options = '<option value="">Select City...</option>';
  
            res.data.forEach(obj => {
                options += `<option value="${obj.id}">${obj.name}</option>`;
            });
  
            $(`select[name=${name}]`).html(options);
            $(`select[name=${name}]`).prev().html("");
            $(`select[name=${name}]`).css({display: 'block'});
        },
        error: err => {
            $(`select[name=${name}]`).prev().html(`<b style="color:red">* something went wrong!</b>`);
            console.error(err);
        }
    });
  }