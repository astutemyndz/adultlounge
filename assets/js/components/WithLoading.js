const WithLoading = (component) => {
    return function WihLoadingComponent({ isLoading, ...props }) {
      if (!isLoading) return component();
      return (`<p>Be Hold, fetching data may take some time :)</p>`);
    }
  }
export default WithLoading;