import { getMedia, deleteMedia } from '~/api/media';

const mediaUrl = (media) => {
  if (!media.filename) return '';
  return `/${media.directory}/${media.filename}.${media.extension}`;
};

const media = {
  namespaced: true,

  state: {
    selectedMedia: {
      directory: '',
      filename: '',
      extension: '',
      size: ''
    },
    previewMedia: {
      directory: '',
      filename: '',
      extension: '',
      size: ''
    },
    mediaList: []
  },

  getters: {
    list: (state) => {
      return state.mediaList;
    },

    selectedMedia: (state) => {
      return state.selectedMedia;
    },

    selectedMediaUrl: (state) => {
      return mediaUrl(state.selectedMedia);
    },

    previewMedia: (state) => {
      return state.previewMedia;
    },

    previewMediaUrl: (state) => {
      return mediaUrl(state.previewMedia);
    }
  },

  mutations: {
    SET_MEDIA_LIST: (state, list) => {
      state.mediaList = list;
    },

    SET_MEDIA: (state, media) => {
      state.selectedMedia = media;
    },

    SET_PREVIEW_MEDIA: (state, media) => {
      state.previewMedia = media;
    }
  },

  actions: {
    fetchMedia ({ commit }, type) {
      return new Promise((resolve, reject) => {
        getMedia(type).then(response => {
          commit('SET_MEDIA_LIST', response.data);
          resolve();
        }).catch(error => {
          reject(error);
        });
      });
    },

    setMedia ({ commit }, media) {
      commit('SET_MEDIA', media);
    },

    setPreviewMedia ({ commit }, media) {
      commit('SET_PREVIEW_MEDIA', media);
    }
  }
};

export default media;
