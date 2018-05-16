import * as types from "../mutation-types";
import {popupDelay} from "../../config/config";

export default {
    state : {
        // 顶部提示框
        popupVisible: false,
        // 顶部提示框内容
        popupContent: '',
    },
    mutations : {
        [types.SET_POPUP_VISIBLE](state, visible) {
            state.popupVisible = Boolean(state.popupContent && visible);
        },
        [types.SET_POPUP_CONTENT](state, content) {
            state.popupContent = content;
        },
    },
    actions : {
        setPopup({ commit }, content) {
            commit(types.SET_POPUP_CONTENT, content);
            commit(types.SET_POPUP_VISIBLE, true);
            setTimeout(() => {
                commit(types.SET_POPUP_CONTENT, '');
                commit(types.SET_POPUP_VISIBLE, false);
            }, popupDelay);
        }
    }
}