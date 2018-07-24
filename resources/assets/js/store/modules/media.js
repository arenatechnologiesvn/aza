import { getMedia, deleteMedia } from '~/api/media';
import dummyImage from '~/assets/login_images/dummy-image.jpg';

const mediaUrl = (media) => {
  if (!media) return dummyImage;
  return `/${media.directory}/${media.filename}.${media.extension}`;
};

const media = {
  namespaced: true,

  state: {
    mediaList: [],
    selectedSingleMedia: null,
    selectedMultiMedia: [],
    previewMedia: null
  },

  getters: {
    list: (state) => {
      return state.mediaList;
    },

    selectedSingleMedia: (state) => {
      return {
        id: state.selectedSingleMedia ? state.selectedSingleMedia.id : null,
        url: mediaUrl(state.selectedSingleMedia)
      };
    },

    selectedMultiMedia: (state) => {
      return state.selectedMultiMedia.map(media => {
        return {
          id: media.id,
          url: mediaUrl(media)
        };
      });
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
      state.mediaList = Object.keys(list).map((key) => {
        return list[key];
      });
    },

    SET_SELECTED_MEDIA: (state, { mode, selected }) => {
      if (mode === 'single') {
        state.selectedSingleMedia = state.mediaList.find((media) => {
          return media.id === selected;
        });
      } else {
        state.selectedMultiMedia = state.mediaList.filter((media) => {
          return selected && selected.includes(media.id);
        }) || [];
      }
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

    setSelectedMedia ({ commit }, { mode, selected }) {
      commit('SET_SELECTED_MEDIA', { mode, selected });
    },

    setPreviewMedia ({ commit }, media) {
      commit('SET_PREVIEW_MEDIA', media);
    }
  }
};

export default media;
