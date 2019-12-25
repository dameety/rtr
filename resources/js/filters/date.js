import { format, parseISO } from "date-fns";

export default (value, dateFormat = "MMM do yyyy") => {
  if (!value) {
    return value;
  }
  const date = parseISO(value);
  return format(date, dateFormat);
};
