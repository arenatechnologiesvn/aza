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
    selectedSingleMedia: {},
    selectedMultiMedia: [],
    previewMedia: {}
  },

  getters: {
    list: (state) => {
      return state.mediaList;
    },

    selectedSingleMedia: (state) => {
      return {
        id: state.selectedSingleMedia.id,
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
      state.mediaList = list;
    },

    SET_SELECTED_SINGLE_MEDIA: (state, media) => {
      state.selectedSingleMedia = media;
    },

    SET_SELECTED_MULTI_MEDIA: (state) => {
      const mediaList = Object.keys(state.mediaList).map((key) => {
        return state.mediaList[key];
      });

      state.selectedMediaList = mediaList.filter((item) => {
        return item.selectStatus && item.selectStatus === 1;
      }) || [];
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

    setSelectedSingleMedia ({ commit }, media) {
      commit('SET_SELECTED_SINGLE_MEDIA', media);
    },

    setSelectedMultiMedia ({ commit }) {
      commit('SET_SELECTED_MULTI_MEDIA');
    },

    setPreviewMedia ({ commit }, media) {
      commit('SET_PREVIEW_MEDIA', media);
    }
  }
};

export default media;
