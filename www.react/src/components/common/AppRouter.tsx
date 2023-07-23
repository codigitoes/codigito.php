import { Route, Routes } from "react-router-dom";
import HomePage from "../../pages/home";
import VideosPage from "../../pages/videos";
import RouterLayout from "./RouterLayout";
import LoginPage from "../../pages/login/login";

const AppRouter: React.FC<unknown> = () => {
    return (
        <Routes>
            <Route path="/" element={<RouterLayout/>}>
                <Route path="/" element={<HomePage/>}/>
                <Route path="/videos" element={<VideosPage/>} />
            </Route>
            <Route path="/login" element={<LoginPage/>} />
        </Routes>
    );
}

export default AppRouter;