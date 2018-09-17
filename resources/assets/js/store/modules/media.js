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
    selectedMultiMedia: []
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
    }
  },

  mutations: {
    SET_MEDIA_LIST: (state, list) => {
      state.mediaList = list;
    },

    SET_SELECTED_MEDIA: (state, { mode, selected }) => {
      if (mode === 'single') {
        // Make watch of selectedSingleMedia in the forms
        // which use this getters will be refreshed
        state.selectedSingleMedia = null;

        state.selectedSingleMedia = state.mediaList.find((media) => {
          return media.id === selected;
        });
      } else {
        // Make watch of selectedMultiMedia in the forms
        // which use this getters will be refreshed
        state.selectedMultiMedia = [];

        state.selectedMultiMedia = state.mediaList.filter((media) => {
          return selected && selected.includes(media.id);
        }) || [];
      }
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
    }
  }
};

export default media;
