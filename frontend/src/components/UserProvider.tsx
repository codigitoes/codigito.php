import { createContext, useContext, useState } from 'react';

const UserContext = createContext(null);
const useUserContext = () => {
    return useContext(UserContext);
};

const UserToggleContext = createContext<any>({});

const useUserToggleContext = () => {
    return useContext(UserToggleContext);
};

const UserProvider = ({ children }) => {
    const [token, setToken] = useState(null);

    return (
        <UserContext.Provider value={token}>
            <UserToggleContext.Provider value={setToken}>
                {children}
            </UserToggleContext.Provider>
        </UserContext.Provider>
    );
};

export default UserProvider;
export { useUserContext, useUserToggleContext };
