import * as types from './mutation-types';
import { popupDelay } from './../config/config'

export function setPopup({ commit }, content) {
    commit(types.SET_POPUP_CONTENT, content);
    commit(types.SET_POPUP_VISIBLE, true);
    setTimeout(() => {
        commit(types.SET_POPUP_CONTENT, '');
        commit(types.SET_POPUP_VISIBLE, false);
    }, popupDelay);
}