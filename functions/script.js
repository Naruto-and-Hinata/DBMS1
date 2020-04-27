function addFriend(id){
        axios.post('../actions/actions.php',{
            friend_id:id
        }).then(res=>{
            console.log(res.data);
        })
    }

function declineFriend(id){
	axios.post('../actions/actions.php',{
		decline:id
	}).then(res=>{
		console.log(res.data);
	})
}