import { Route, Routes } from "react-router-dom";
import Dashboard from "../dashboard/Dashboard";
import BlogPage from "../blog";

const App: React.FC = () => {
    return (
        <Routes>
            <Route path='/' element={<Dashboard />} />
            <Route path='/blog' element={<BlogPage />} />
        </Routes>
    );
}

export default App;