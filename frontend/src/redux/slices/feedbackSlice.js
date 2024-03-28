import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import http from "../../http-common";

const initialState = {
  tempFeedback: {},
  allFeedbacks: [],
  allPages: 0,
  message: {
    status: 0,
    content: ""
  },
  updated: false,
  deleted: false,
  postResult: {}
}

export const postAFeedback = createAsyncThunk(
  "reviews/post",
  async (payload) => {
    const res = await http.post("reviews", payload);
    return res.data;
  }
)
export const getAllFeedbacks = createAsyncThunk(
  "reviews/all",
  async (payload) => {
    const res = await http.get(`reviews?page=${payload.page}&unit=${payload.unit}`);
    return res.data;
  }
)
export const updateAFeedback = createAsyncThunk(
  "reviews/update",
  async (payload) => {
    const res = await http.put(`reviews/${payload.id}`, {
      response: payload.response
    });
    return res.data;
  }
)
export const deleteAFeedback = createAsyncThunk(
  "reviews/delete",
  async (payload) => {
    const res = await http.delete(`reviews/${payload.id}`);
    return res.data;
  }
)

export const feedbackSlice = createSlice({
  name: "feedback",
  initialState,
  reducers: {
    postTempFeedback: (state, action) => {
      state.tempFeedback = { ...action.payload };
    },
    resetUpdatedState: (state) => {
      state.updated = false;
    },
    resetDeletedState: (state) => {
      state.deleted = false;
    },
    resetFeedbackMessage: (state) => {
      state.message = {
        status: 0,
        content: ""
      }
    }
  },
  extraReducers: (builder) => {
    builder
      .addCase(postAFeedback.fulfilled, (state, action) => {
        state.postResult = { ...action.payload.insertedReview };
        state.message.status = 200;
        state.message.content = action.payload.message;
      })
      .addCase(postAFeedback.rejected, (state, action) => {
        state.message.status = 401;
        state.message.content = 'このレビューの投稿は失敗しました。';
      })
      .addCase(getAllFeedbacks.fulfilled, (state, action) => {
        state.allFeedbacks = [...action.payload.payload.allReviews];
        state.allPages = action.payload.payload.allPages;
      })
      .addCase(updateAFeedback.fulfilled, (state, action) => {
        // const index = state.allFeedbacks.findIndex(item => item.id === action.payload.updatedReview.id);
        // state.allFeedbacks[index] = action.payload.updatedReview;
        state.updated = true;
        state.message.status = 200;
        state.message.content = action.payload.message;
      })
      .addCase(updateAFeedback.rejected, (state, action) => {
        state.updated = false;
        state.message.status = 401;
        state.message.content = '更新に失敗しました。';
      })
      .addCase(deleteAFeedback.fulfilled, (state, action) => {
        state.deleted = true;
        state.message.status = 200;
        state.message.content = action.payload.message;
      })
      .addCase(deleteAFeedback.rejected, (state,action) => {
        state.deleted = false;
        state.message.status = 401;
        state.message.content = '削除に失敗しました。';
      })
  }
});

export const { postTempFeedback, resetFeedbackMessage, resetUpdatedState, resetDeletedState } = feedbackSlice.actions;
export default feedbackSlice.reducer;