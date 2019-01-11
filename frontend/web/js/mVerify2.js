swal({
    title: "",
    text: "请完善二级密码，完善后才能进行转账、编辑等操作",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#2196f3",
    confirmButtonText: "马上完善!",
    cancelButtonText: "稍后再说!",
    closeOnConfirm: false
},
function() {
    window.location="/user/pass?type=2";
});