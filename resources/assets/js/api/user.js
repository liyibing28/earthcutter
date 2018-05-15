export function sendRegisterReq(formData) {
    const url = 'api/register';

    return axios.post(url,formData).then(response => {
        this.$router.push({name: 'map'});
    })
}