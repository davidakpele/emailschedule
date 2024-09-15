

class api {
    
    login = async ({ ...data }) => {
        fetch('login', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response data here
            if (data.status) {
                document.querySelector("#password-error").innerHTML =  data.message;
            } else {
                window.location.reload();
            }
        })
        .catch(error => {
          console.error('Error:', error);
          // Handle errors here
        });
    }

    register = async ({ ...data }) => {
        $(".success").hide();
        fetch('register', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response data here
            if (data.status) {
                $(".success").hide();
                document.querySelector("#password-error").innerHTML =  data.message;
            } else {
                $(".success").show();
                document.querySelector("#messagediv").innerHTML =  data.message;
            }
        })
        .catch(error => {
          console.error('Error:', error);
          // Handle errors here
        });
    }
}

export default api