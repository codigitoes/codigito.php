import { Route, Routes } from "react-router-dom";
import HomePage from "../pages/home";
import VideosPage from "../pages/videos";
import RouterLayout from "./common/RouterLayout";

const AppRouter: React.FC<unknown> = () => {
    return (
        <Routes>
            <Route path="/" element={<RouterLayout/>}>
                <Route path="/" element={<HomePage/>}/>
                <Route path="/videos" element={<VideosPage/>} />
            </Route>
        </Routes>
    );
}

export default AppRouter;