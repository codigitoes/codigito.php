import { Route, Routes } from "react-router-dom";
import HomePage from "../../pages/home";
import LoginPage from "../../pages/login/login";
import PublicLayout from "../common/PublicLayout";

const AppRouter: React.FC<unknown> = () => {
    return (
        <Routes>
            <Route path="/" element={<PublicLayout/>}>
                <Route path="/" element={<HomePage/>}/>
            </Route>
            <Route path="/login" element={<LoginPage/>} />
        </Routes>
    );
}

export default AppRouter;