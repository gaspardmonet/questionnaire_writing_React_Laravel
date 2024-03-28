import React, { useEffect } from "react";
import { useNavigate } from "react-router-dom";
import Box from '@mui/material/Box';
import LinearProgress from '@mui/material/LinearProgress';

const WaitingPostBadFeedback = () => {
  const navigate = useNavigate();
  useEffect(() => {
    const timer = setTimeout(() => {
      navigate("/smile/post/bad_feedback");
    }, 5000);
    return () => {
      clearTimeout(timer);
    }
  })
  return (
    <div className="w-full h-screen flex justify-center items-center">
      <div className="sm:w-[62rem] w-full flex flex-col justify-center items-center border-[2px] border-[#4085c9] rounded-[1rem] overflow-hidden shadow-2xl">
        <h1 className="w-full text-center bg-[#4085c9] text-white text-[3.5rem] py-[1rem] font-semibold">
          アンケート調査
        </h1>
        <div className="w-[80%] my-[7rem] text-center">
          <p className="text-[2.5rem] font-normal">
            具体的な内容を教えてください。
          </p>
          <p className="text-[2rem] font-normal mt-[1rem]">
            ※数秒後に自動的に評価と口コミ画面に切り替わります。
          </p>
        </div>
        <Box sx={{ width: '100%' }}>
          <LinearProgress />
        </Box>
        <div className="w-full flex justify-evenly items-center my-[1.5rem]">
          <button className="block w-[40%] rounded-full border-[2px] border-[rgba(0,0,0,0.03)] bg-[rgba(0,0,0,0.5)] hover:bg-white hover:text-[rgba(0,0,0,0.5)] hover:border-[rgba(0,0,0,0.5)] text-white text-[2rem] py-[1.5rem]"
            onClick={() => navigate("/smile")}>
            キャンセル
          </button>
          <button className="block w-[40%] rounded-full border-[2px] border-[#4085c9] bg-[#4085c9] hover:bg-white hover:text-[#4085c9] text-white text-[2rem] py-[1.5rem]"
            onClick={() => navigate("/smile/post/bad_feedback")}>
            次へ
          </button>
        </div>
      </div>
    </div>
  );
}

export default WaitingPostBadFeedback;