import { createContext, useContext } from "react";
import useFetch from "../hooks/useFetch";
import { CircularProgress } from "@mui/material";

const TagsContext = createContext([]);
const useTagsContext = () => {
  return useContext(TagsContext);
};
const endpoint = "http://localhost:8001/api/client/web/tags";

const TagsProvider = ({ children }) => {
  const fetchState = useFetch<{
    tags: any;
    selected?: any;
  }>(endpoint);
  if (fetchState.state === "loading" || fetchState.state === "idle") {
    return (
      <div>
        <CircularProgress />
      </div>
    );
  }

  const valueProvider = {
    tags: fetchState.data?.tags ? fetchState.data?.tags : [],
    selected: "libros",
  };

  return (
    <TagsContext.Provider value={valueProvider}>
      {children}
    </TagsContext.Provider>
  );
};

export default TagsProvider;
export { useTagsContext };
