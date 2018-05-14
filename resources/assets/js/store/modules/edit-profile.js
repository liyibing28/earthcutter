import jwtToken from './../../helpers/jwt'
import jwt from "../../helpers/jwt";
import * as types from "../mutation-types";

export default {
    actions :  {
        updateProfileRequest({dispatch},formData){
            return axios.post('/api/user/profile/update',formData).then(response => {
                //dispatch('loginSuccess',response.data)
            }).catch(error =>{

            })
        },
    }
}