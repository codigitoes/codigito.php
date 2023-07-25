import { Route, Routes } from "react-router-dom";
import RouterLayout from "./RouterLayout";
import LoginPage from "../../pages/login/login";
import HomePage from "../../pages/home";

const AppRouter: React.FC<unknown> = () => {
    return (
        <Routes>
            <Route path="/" element={<RouterLayout/>}>
                <Route path="/" element={<HomePage/>}/>
            </Route>
            <Route path="/login" element={<LoginPage/>} />
        </Routes>
    );
}

export default AppRouter;